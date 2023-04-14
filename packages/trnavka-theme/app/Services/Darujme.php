<?php

namespace App\Services;

use App\Repositories\CampaignRepository;
use DateTimeImmutable;
use Exception;
use Illuminate\Support\Facades\DB;
use League\Csv\Writer;
use function Symfony\Component\String\u;

class Darujme
{
    public function __construct(private CampaignRepository $campaignRepository)
    {
    }

    public function updateCampaigns(): void
    {
        foreach ($this->campaignRepository->findAll() as $campaign) {
            $response = json_decode(file_get_contents(sprintf('https://api.darujme.sk/v1/feeds/%s/donations/?per_page=1', $campaign->darujmeFeedId)), true);
            update_post_meta($campaign->id, 'dajnato_campaign_current_amount', (float)((($response['response'] ?? [])['metadata'] ?? [])['total_amount'] ?? 0));
        }
    }

    public function generateDonorCsv(): string
    {
        $dates = DB::select(DB::raw("
            SELECT
                MAX(received_at) AS end_received_at,
                MIN(received_at) AS start_received_at
            FROM
                wp_darujme_payments
        "))[0];

        $months = $this->months($this->date($dates->start_received_at)->format('Y-m'), $this->date($dates->end_received_at)->format('Y-m'));

        $campaigns = [];

        foreach (DB::select(DB::raw("
            SELECT
                DISTINCT IFNULL(c.authoritative_name, p.campaign) AS name
            FROM
                wp_darujme_payments AS p
            LEFT JOIN
                wp_darujme_campaigns AS c
            ON
                p.campaign = c.name
        ")) as $campaign) {
            $campaigns[$campaign->name] = 0;
        }

        $paymentTypes = [
            'karta' => 0,
            'prevod' => 0,
            'ib' => 0,
        ];

        $payments = DB::select(DB::raw("
            SELECT
                IFNULL(u.authoritative_email, p.email) AS email,
                IFNULL(c.authoritative_name, p.campaign) AS campaign,
                p.name,
                p.surname,
                p.value,
                p.payment_type,
                p.received_at
            FROM
                wp_darujme_payments AS p
            LEFT JOIN
                wp_darujme_users AS u
            ON
                p.email = u.email
            LEFT JOIN
                wp_darujme_campaigns AS c
            ON
                p.campaign = c.name
        "));

        $donors = [];
        $startMonth = null;
        $endMonth = null;

        foreach ($payments as $payment) {
            $name = sprintf("%s %s", $payment->surname, $payment->name);
            $receivedAtMonth = $this->date($payment->received_at)->format('Y-m');

            if ('transfer' === $payment->payment_type) {
                $paymentType = 'prevod';
            } elseif (str_contains($payment->payment_type, 'card')) {
                $paymentType = 'karta';
            } else {
                $paymentType = 'ib';
            }

            $startMonth = null === $startMonth || $receivedAtMonth < $startMonth ? $receivedAtMonth : $startMonth;
            $endMonth = null === $endMonth || $receivedAtMonth > $endMonth ? $receivedAtMonth : $endMonth;

            $donor = $donors[$payment->email] ?? [
                'total' => 0,
                'email' => $payment->email,
                'campaigns' => $campaigns,
                'names' => [],
                'payment_types' => $paymentTypes,
                'months' => $months
            ];

            $donor['total'] += $payment->value;
            $donor['names'][u($name)->ascii()->toString()] = $name;
            $donor['campaigns'][$payment->campaign] += $payment->value;
            $donor['payment_types'][$paymentType] += $payment->value;

            $donor['months'][$receivedAtMonth] += $payment->value;
            $donors[$payment->email] = $donor;
        }

        $writer = Writer::createFromString();
        $writer->insertOne(array_merge(
                [
                    'Email',
                    'Meno',
                    'Total'
                ],
                array_keys($paymentTypes),
                array_keys($campaigns),
                array_keys($months),
            )
        );

        $formattedValues = fn(
            $values
        ) => array_map(fn(
            $value
        ) => 0 === $value ? '' : round($value / 100, 2), $values);

        foreach ($donors as $donor) {
            $names = $donor['names'];
            usort($names, fn(
                $a,
                $b
            ) => strlen($a) - strlen($b));

            $writer->insertOne(array_merge(
                [
                    $donor['email'],
                    current($names),
                    round($donor['total'] / 100, 2),
                ],
                $formattedValues($donor['payment_types']),
                $formattedValues($donor['campaigns']),
                $formattedValues($donor['months']),
            ));
        }

        file_put_contents('donors.csv', $writer->toString());
    }

    private function date(string $date): DateTimeImmutable
    {
        return new DateTimeImmutable($date, new \DateTimeZone('UTC'));
    }

    private function months(
        string $startMonth,
        string $endMonth
    ): array
    {
        [$year, $month] = explode('-', $startMonth);
        [$endYear, $endMonth] = explode('-', $endMonth);
        $months = [];

        $year = (int)$year;
        $month = (int)$month - 1;
        $endYear = (int)$endYear;
        $endMonth = (int)$endMonth;

        do {

            $month++;

            if (13 === $month) {
                $month = 1;
                $year++;
            }

            $months[sprintf('%d-%02d', $year, $month)] = 0;
        } while ($year !== $endYear || $month !== $endMonth);

        return array_reverse($months);
    }

    public function updatePayments(): void
    {
        $this->updateDarujmePayments(
            'trnavka',
            $this->parameter('DARUJME_API_USERNAME'),
            $this->parameter('DARUJME_API_PASSWORD'),
            $this->parameter('DARUJME_ORGANISATION_ID')
        );

        $splitDate = new DateTimeImmutable('2022-02-21');

        $this->updateDarujmePayments(
            'provincia',
            $this->parameter('DARUJME_API_PROVINCIA_USERNAME'),
            $this->parameter('DARUJME_API_PROVINCIA_PASSWORD'),
            $this->parameter('DARUJME_PROVINCIA_ORGANISATION_ID'),
            fn($payment) => new DateTimeImmutable($payment['happened_at']) >= $splitDate && $payment['donation']['campaign']['note'] === 'ĽudiaĽuďom'
        );

//        DB::statement("DELETE FROM `wp_darujme_payments` WHERE `source` = 'provincia' AND (received_at < '2022-02-21' OR campaign != 'ĽudiaĽuďom')");
    }

    private function updateDarujmePayments(
        string $darujmeSource,
        string $darujmeUsername,
        string $darujmePassword,
        string $darujmeOrganisationId,
        ?callable $isValidPayment = null
    ): void
    {
        echo "Fetching payments for $darujmeSource...\n";

        try {
            $page = 1;
            $token = $this->auth($darujmeUsername, $darujmePassword, $darujmeOrganisationId);

            $lastPayment = DB::table('darujme_payments')->select('payment_id', 'updated_at')->where('source', '=', $darujmeSource)
                ->orderByDesc('received_at')->limit(1)->get()->first();

            $lastUpdatedAt = (new DateTimeImmutable($lastPayment?->updated_at ?? '2010-01-01', new \DateTimeZone('UTC')))->format(DateTimeImmutable::RFC3339);

            dump($lastUpdatedAt);

            do {
                $response = $this->request('GET', '/v1/payments/', $darujmeOrganisationId, $token, null, [
                    'status' => 'successful',
                    'limit' => 1000,
                    'page' => $page,
                    'updated_gte' => $lastUpdatedAt
                ]);

                print_r($response['metadata']);

                foreach ($response['items'] ?? [] as $payment) {
                    if ('successful' !== $payment['status'] || $lastPayment?->payment_id === $payment['id'] || (is_callable($isValidPayment) && !$isValidPayment($payment))) {
                        continue;
                    }

                    $now = (new DateTimeImmutable())->setTimezone(new \DateTimeZone('Europe/Bratislava'))->format('Y-m-d H:i:s');

                    $updateFields = [
                        'source' => $darujmeSource,
                        'payment_id' => $payment['id'],
                        'name' => $payment['donation']['donor']['name'],
                        'surname' => $payment['donation']['donor']['surname'],
                        'email' => $payment['donation']['donor']['email'],
                        'variable_symbol' => $payment['variable_symbol'],
                        'periodicity' => $payment['donation']['periodicity'],
                        'value' => (int)round($payment['value'] * 100),
                        'payment_type' => $payment['donation']['payment_method']['handle'],
                        'campaign' => $payment['donation']['campaign']['note'],
                        'received_at' => new DateTimeImmutable($payment['happened_at']),
                        'registered_at' => new DateTimeImmutable($payment['created_at']),
                        'updated_at' => $now,
                    ];

                    $createFields = [
                        'created_at' => $now,
                    ];

                    DB::table('darujme_payments')->upsert($updateFields + $createFields, 'payment_id', array_keys($updateFields));
                }
                $page++;
            } while ($page <= ($response['metadata'] ?? [])['pages'] ?? 0);
        } catch (Exception $e) {
            echo sprintf('Error: %s', $e->getMessage());
            exit;
        }
    }

    public function subscriptionStats(): \stdClass
    {
        return DB::select(DB::raw("
                SELECT
	                SUM(p.value) AS sum,
                    COUNT(DISTINCT IFNULL(u.authoritative_email, p.email)) AS count
                FROM
                    wp_darujme_payments AS p
                LEFT JOIN
                    wp_darujme_users AS u
                ON
                    p.email = u.email
                WHERE
                    p.campaign IN ('dielo_trnavka', 'ba_trnavka_dielo_trnavka')
                        AND
                    p.received_at >= '2023-01-01 00:00:00'"))[0];
    }

    public function stats(): array
    {
        return [
            'all_payments' => $this->statsPayments(),
            'old_dielo_payments' => $this->statsPayments(['ba_trnavka_dielo_trnavka'], 'DATE_FORMAT(registered_at, \'%Y-%m\')'),
            'new_dielo_payments' => $this->statsPayments(['dielo_trnavka'], 'DATE_FORMAT(registered_at, \'%Y-%m\')'),
        ];
    }

    private function statsPayments(
        array|null $campaigns = null,
        string     $groupBy = 'YEAR(p.received_at)'
    ): array
    {
        $campaignsCondition = '';

        if (is_array($campaigns)) {
            $campaignsCondition = 'WHERE p.campaign IN (' . implode(',', array_map(fn(
                    $campaign
                ) => "'$campaign'", $campaigns)) . ')';
        }

        return [
            'all_users' => DB::select(DB::raw(sprintf(
                'SELECT
                    COUNT(DISTINCT IFNULL(u.authoritative_email, p.email)) AS count
                FROM
                    wp_darujme_payments AS p
                LEFT JOIN
                    wp_darujme_users AS u
                ON
                    p.email = u.email
                %s
                ', $campaignsCondition)))[0]->count,
            'by_year' => DB::select(DB::raw(sprintf(
                'SELECT
                    %s AS year,
                    COUNT(DISTINCT IFNULL(u.authoritative_email, p.email)) AS count,
                    SUM(p.value) AS sum
                FROM
                    wp_darujme_payments AS p
                LEFT JOIN
                    wp_darujme_users AS u
                ON
                    p.email = u.email
                %s
                GROUP BY
                    YEAR
                ORDER BY
                    YEAR DESC
                ', $groupBy, $campaignsCondition))),
        ];
    }

    /**
     * @param string $login
     * @param string $password
     * @return string
     * @throws Exception
     */
    private function auth(
        string $login,
        string $password,
        string $organisationId
    ): string
    {
        $response = $this->request('POST', '/v1/tokens/', $organisationId, null, [
            'username' => $login,
            'password' => $password,
        ]);

        if (isset($response['error'])) {
            throw new Exception($response['error']['message']);
        }

        return $response['response']['token'];
    }

    private function request(
        string      $method,
        string      $path,
        string      $darujmeOrganisationId,
        string|null $token = null,
        array|null  $data = null,
        array       $urlParameters = []
    ): array
    {
        $url = 'https://api.darujme.sk' . $path;

        $ch = curl_init($url . '?' . http_build_query($urlParameters));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        if (null === $data) {
            $payload = '';
        } else {
            $payload = json_encode($data);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        }

        $headers = [
            'Content-Type: application/json',
            'X-ApiKey: ' . $this->parameter('DARUJME_API_KEY'),
            'X-Organisation: ' . $darujmeOrganisationId,
            'X-Signature: ' . $this->signature($payload, $path)
        ];

        if (null !== $token) {
            $headers[] = 'Authorization: TOKEN ' . $token;
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);

        return json_decode($response, true);
    }

    /**
     * @throws Exception
     */
    private function parameter(string $name): string
    {
        return env($name) ?? throw new Exception(sprintf('Missing environment parameter "%s"', $name));
    }

    private function signature(
        string $payload,
        string $url
    ): string
    {
        return hash_hmac('sha256', "$payload:$url", $this->parameter('DARUJME_API_SECRET'));
    }
}
