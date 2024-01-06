<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Year2023Page extends Composer
{
    /**
     * @var array
     */
    protected static $views = [
        '2023',
    ];

    public function override(): array
    {
        add_action('wp_head', function () {
            echo '<meta name="og:title" content="Rok 2023 u saleziánov na Trnávke" />';
            echo '<meta name="og:description" content="Prehľad roka 2023 v Saleziánskom diele na Trnávke. Pozrite si zaujímave čísla a prehľad aktivít." />';
            echo '<meta name="og:url" content="https://trnavka.sk/rok-2023/" />';
            echo '<meta name="og:image" content="' . asset('images/2023/share.png')->uri() . '" />';
        });

        return [];
    }
}
