<?php

namespace App\Services;

use App\Repositories\CampaignRepository;
use DateTimeImmutable;
use Exception;
use Illuminate\Support\Facades\DB;

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

    public function updatePayments(): void
    {
        try {
            $page = 1;
            $token = $this->auth($this->parameter('DARUJME_API_USERNAME'), $this->parameter('DARUJME_API_PASSWORD'));

            $payments = DB::table('darujme_payments')->select('received_at')
                ->orderByDesc('received_at')->limit(1)->get()->first();

            $lastReceivedAt = (new DateTimeImmutable($payments?->received_at ?? '2019-01-01', new \DateTimeZone('UTC')))->format(DateTimeImmutable::RFC3339);

            do {
                $response = $this->request('GET', '/v1/payments/', $token, null, [
                    'status' => 'successful',
                    'limit' => 1000,
                    'page' => $page,
                    'updated_gte' => $lastReceivedAt
                ]);

                print_r($response['metadata']);

                foreach ($response['items'] ?? [] as $payment) {
                    $now = (new DateTimeImmutable())->setTimezone(new \DateTimeZone('Europe/Bratislava'))->format('Y-m-d H:i:s');

                    $updateFields = [
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

    private function statsPayments(array|null $campaigns = null, string $groupBy = 'YEAR(p.received_at)'): array
    {
        $campaignsCondition = '';

        if (is_array($campaigns)) {
            $campaignsCondition = 'WHERE p.campaign IN (' . implode(',', array_map(fn($campaign
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
                    year
                ORDER BY
                    year DESC
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
        string $password
    ): string
    {
        $response = $this->request('POST', '/v1/tokens/', null, [
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
            'X-Organisation: ' . $this->parameter('DARUJME_ORGANISATION_ID'),
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
