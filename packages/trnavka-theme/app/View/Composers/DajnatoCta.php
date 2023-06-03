<?php

namespace App\View\Composers;

use App\Services\Dajnato;
use Roots\Acorn\View\Composer;

class DajnatoCta extends Composer
{
    private static int $prefixCount = 0;

    /**
     * @var array
     */
    protected static $views = [
        'blocks.dajnato-cta',
    ];

    public function __construct(
        private Dajnato $dajnato,
    )
    {
    }

    public function with(): array
    {
        $campaign = $this->dajnato->campaign();
        $attributes = $this->view->getData()['attributes'] ?? [];

        return [
            'dajnato_cta_form_url' => $this->dajnato->formUrl($campaign->id, true),
            'dajnato_cta_title' => $attributes['title'] ?? 'Mesačne budem prispievať do Daj na to!',
            'dajnato_cta_button' => $attributes['button'] ?? 'Pokračovať',
            'dajnato_cta_values' => $this->dajnato->campaignValues($campaign),

            'prefix' => 'p' . (++self::$prefixCount),
        ];
    }
}
