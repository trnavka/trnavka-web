<?php

namespace App\View\Composers;

use App\Services\WordPress;
use Roots\Acorn\View\Composer;

class YearlyOverview extends Composer
{
    /**
     * @var array
     */
    protected static $views = [
        'yearly-overview',
    ];

    public function __construct(private WordPress $wp)
    {
    }

    public function override(): array
    {
        add_action('wp_head', function () {
            $year = $this->wp->currentPost()->post_title;

            echo '<meta name="og:title" content="Rok ' . $year . ' u saleziánov na Trnávke" />';
            echo '<meta name="og:description" content="Prehľad roka ' . $year . ' v Saleziánskom diele na Trnávke. Pozrite si zaujímave čísla a prehľad aktivít." />';
            echo '<meta name="og:url" content="https://trnavka.sk/rok-' . $year . '/" />';
            echo '<meta name="og:image" content="' . asset('images/' . $year . '/share.png')->uri() . '" />';
        });

        return [];
    }
}
