<?php

namespace App\View\Composers;

use App\Services\HtmlHeader;
use Roots\Acorn\View\Composer;

class Header extends Composer
{
    /**
     * @var array
     */
    protected static $views = [
        'sections.header',
    ];

    public function __construct(private HtmlHeader $htmlHeader)
    {
    }

    public function with(): array
    {
        return [
            'header' => $this->htmlHeader->getContent()
        ];
    }
}
