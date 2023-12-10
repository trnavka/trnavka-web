<?php

namespace App\View\Composers;

use App\Services\Legacy;
use Roots\Acorn\View\Composer;

class Homepage extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'homepage',
    ];

    public function __construct(
        private Legacy $legacy
    )
    {
    }

    public function with(): array
    {
        return [
            'latest_posts' => $this->legacy->lastestPosts(),
        ];
    }
}
