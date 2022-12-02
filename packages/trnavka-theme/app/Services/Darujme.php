<?php

namespace App\Services;

use App\Repositories\CampaignRepository;

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
}
