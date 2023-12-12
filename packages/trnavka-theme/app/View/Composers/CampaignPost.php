<?php

namespace App\View\Composers;

use App\Entity\Campaign;
use App\Services\Dajnato;
use Roots\Acorn\View\Composer;
use Roots\WPConfig\Config;
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
        $showOnlyShare = 'T' === $this->request->query->get('share', 'F');
        $view = $this->request->query->get('view');
        $views = [
            'current' => 'Aktuálna suma',
            'rest' => 'Chýbajúca suma',
            'dajnato-current' => 'Aktuálna suma (iba Dajnato)',
        ];

        if (!empty($view)) {
            if (isset($views[$view]))  {
                echo $this->handleCampaignView($view, $campaign);
                exit;
            }

            echo '';
            exit;
        }

        if ($showOnlyForm || $showOnlyShare) {
            add_filter('wp_robots', 'wp_robots_no_robots');
        }

        add_action( 'wp_head', function() use ($campaign) {
            if (str_contains($campaign->title, 'hranolov')) {
                echo '<meta name="og:image" content="' . get_template_directory_uri() . '/public/static/dajnato-hranoly-share-image-v3.png" />';
            }
        });

        return [
            'views' => $views,
            'view' => $view,
            'dev_share_javascript' => $GLOBALS['SHARE_JAVASCRIPT'],
            'share_javascript' => Config::get('WP_HOME') . preg_replace('/share.[a-z0-9]+\.js$/', 'share.js', $GLOBALS['SHARE_JAVASCRIPT']),
            'campaign' => $campaign,
            'campaign_url' => "/dajnato/{$campaign->slug}/",
            'show_only_form' => $showOnlyForm,
            'show_only_share' => $showOnlyShare,
            'dajnato_cta_form_url' => $this->dajnato->formUrl($campaign->id, true)
        ];
    }

    private function handleCampaignView(
        string   $view,
        Campaign $campaign
    )
    {
        switch ($view) {
            case 'current':
                return $campaign->getCurrentAmountFormatted();
            case 'rest':
                return $campaign->getDajnatoRestAmountFormatted();
            case 'dajnato-current':
                return $campaign->getCurrentDajnatoAmountFormatted();
        }

        return '';
    }
}
