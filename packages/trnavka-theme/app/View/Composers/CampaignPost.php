<?php

namespace App\View\Composers;

use App\Services\Dajnato;
use Roots\Acorn\View\Composer;

class CampaignPost extends Composer
{
    /**
     * @var array
     */
    protected static $views = [
        'partials.content-single-campaign',
    ];

    public function __construct(
        private Dajnato $dajnato
    )
    {
    }

    public function override(): array
    {
        $campaign = $this->dajnato->campaign($this->view);

        return [
            'campaign' => $campaign,
            'dajnato_cta_form_url' => $this->dajnato->formUrl($campaign->id, true)
        ];
    }
}
