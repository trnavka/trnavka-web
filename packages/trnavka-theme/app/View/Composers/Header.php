<?php

namespace App\View\Composers;

use App\Services\HtmlHeader;
use Roots\Acorn\View\Composer;
use Symfony\Component\HttpFoundation\Request;

class Header extends Composer
{
    /**
     * @var array
     */
    protected static $views = [
        'sections.header',
    ];

    public function __construct(
        private HtmlHeader $htmlHeader,
        private Request    $request
    )
    {
    }

    public function with(): array
    {
        if ('T' === $this->request->query->get('refresh-header', 'F')) {
            $this->htmlHeader->loadAndCache();
        }

        return [
            'header' => $this->htmlHeader->getContent()
        ];
    }
}
