<?php

namespace App\Console\Commands;

use DateTimeImmutable;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateDarujmeStats extends Command
{
    protected $signature = 'update:darujme-stats';

    protected $description = 'Update stats from Darujme.sk';

    public function handle()
    {
        $this->info('Updating Darujme.sk stats');

        try {
            $page = 1;
            $token = $this->auth($this->parameter('DARUJME_API_USERNAME'), $this->parameter('DARUJME_API_PASSWORD'));

            do {
                $response = $this->request('GET', '/v1/payments/', $token, null, ['status' => 'successful', 'limit' => 1000, 'page' => $page]);
                foreach ($response['items'] ?? [] as $payment) {
                    DB::table('darujme_payments')->insert([
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
                    ]);
                }
                dump($response['metadata']);
                $page++;
            } while ($page <= ($response['metadata'] ?? [])['pages'] ?? 0);

        } catch (Exception $e) {
            $this->error(sprintf('Error: %s', $e->getMessage()));
        }

        $this->info('DONE.');
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
        string $method,
        string $path,
        string|null $token = null,
        array|null $data = null,
        array $urlParameters = []
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
        return env($name) ?? throw new \Exception(sprintf('Missing environment parameter "%s"', $name));
    }

    private function signature(
        string $payload,
        string $url
    ): string
    {
        return hash_hmac('sha256', "$payload:$url", $this->parameter('DARUJME_API_SECRET'));
    }
}
