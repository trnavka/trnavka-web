<?php

namespace App\View\Composers;

use App\Services\WordPress;
use Roots\Acorn\View\Composer;

class Post extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.content',
        'partials.content-*',
    ];

    public function __construct(private WordPress $wp)
    {
    }

    public function override(): array
    {
        return [
            'title' => $this->wp->title(),
        ];
    }
}
