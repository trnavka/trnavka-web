<?php

namespace App\View\Composers;

use App\Services\Dajnato;
use Roots\Acorn\View\Composer;
use Symfony\Component\HttpFoundation\Request;

class CampaignPost extends Composer
{
    /**
     * @var array
     */
    protected static $views = [
        'partials.content-single-campaign',
    ];

    public function __construct(
        private Dajnato $dajnato,
        private Request $request,
    )
    {
    }

    public function override(): array
    {
        $campaign = $this->dajnato->campaign($this->view);
        $showOnlyForm = 'T' === $this->request->query->get('of', 'F');

        if ($showOnlyForm) {
            add_filter( 'wp_robots', 'wp_robots_no_robots' );
        }

        return [
            'campaign' => $campaign,
            'show_only_form' => $showOnlyForm,
            'dajnato_cta_form_url' => $this->dajnato->formUrl($campaign->id, true)
        ];
    }
}
