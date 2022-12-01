<?php

namespace App\Services;

use WP_Post;

class WordPress
{
    public function currentPost(): WP_Post|null
    {
        return get_post();
    }

    public function title(): string
    {
        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }

            return __('Latest Posts', 'sage');
        }

        if (is_archive()) {
            return get_the_archive_title();
        }

        if (is_search()) {
            return sprintf(
            /* translators: %s is replaced with the search query */
                __('Search Results for %s', 'sage'),
                get_search_query()
            );
        }

        if (is_404()) {
            return __('Not Found', 'sage');
        }

        return get_the_title();
    }

    public function postUrl(?WP_Post $post = null): string
    {
        return get_permalink($post ?? $this->currentPost());
    }

    public function pageUrl(): string
    {
        return get_page_link();
    }
}
