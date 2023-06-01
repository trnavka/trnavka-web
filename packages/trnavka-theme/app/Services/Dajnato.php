<?php

namespace App\Services;

use App\Entity\Campaign;
use App\Repositories\CampaignRepository;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Request;

class Dajnato
{
    public function __construct(
        private CampaignRepository $campaignRepository,
        private WordPress          $wp,
        private Request            $request
    )
    {
    }

    private function isEmpty(array $options): bool
    {
        return collect($options)->reject(fn($value) => empty($value))->count() === 0;
    }

    private function campaignDefaultOptions(Campaign $campaign): array
    {
        return $this->isEmpty($campaign->recurringOptions) ? $campaign->options : $campaign->recurringOptions;
    }

    public function oneTimePaymentsEnabled(Campaign $campaign): bool
    {
        return !$this->isEmpty($campaign->options);
    }

    public function recurringPaymentsEnabled(Campaign $campaign): bool
    {
        return !$this->isEmpty($campaign->recurringOptions);
    }

    public function campaignValues(Campaign $campaign): Collection
    {
        $options = $this->campaignDefaultOptions($campaign);
        $selectedOptionIndex = (int)ceil(count($options) / 2) - 1;

        return collect($options)->map(fn(
            $option,
            $index
        ) => [
            'value' => $option,
            'selected' => $index === $selectedOptionIndex
        ]);
    }

    public function campaign(?View $view = null): Campaign
    {
        $campaignId = ($view?->getData()['attributes'] ?? [])['campaign_id'] ?? $this->request->get('campaign_id');
        $post = empty($campaignId) ? $this->wp->currentPost() : get_post($campaignId);

        if ($post->post_type !== 'campaign') {
            $post = null;
        }

        if (null !== $post) {
            $campaign = $this->campaignRepository->find($post);

            if (null !== $campaign) {
                return $campaign;
            }
        }

        // fallback - campaign "Dielo na Trnavke"
        return (new Campaign())
            ->setDarujmeId('de161f1d-6f09-4d51-b1ae-d0f2207b9215')
            ->setRecurringOptions([99, 29, 9]);
    }

    public function formUrl(?int $campaignId, bool $modal = false): string
    {
        $params = [];

        if (null !== $campaignId) {
            $params['campaign_id'] = $campaignId;
        }

        if ($modal) {
            $params['modal'] = 'T';
        }

        return rtrim(get_bloginfo('url'), '/') . '/dajnato-form/?' . http_build_query($params);
    }

    public function defaultFormData(Campaign $campaign): array
    {
        $onetime = $this->oneTimePaymentsEnabled($campaign);
        $recurring = $this->recurringPaymentsEnabled($campaign);

        $result = [
            'onetimeOrRecurring' => $recurring ? 'recurring' : 'onetime',
        ];

        if ($recurring) {
            $result['recurringAmount'] = $campaign->recurringOptions[(int)ceil(count($campaign->recurringOptions) / 2) - 1];
        }

        if ($onetime) {
            $result['onetimeAmount'] = $campaign->options[(int)ceil(count($campaign->options) / 2) - 1];
        }

        return $result;
    }

    public function darujmeData(Campaign $campaign, array $data): array
    {
        dd($data);
        return [
            'campaign_id' => $campaign->darujmeId,
            'value' => empty($data['amount']) ? $data['otherAmount'] : $data['amount'],
            'payment_method_id' => $data['paymentType'],
            'first_name' => $data['firstName'],
            'last_name' => $data['lastName'],
            'email' => $data['email'],
        ];
    }
}
