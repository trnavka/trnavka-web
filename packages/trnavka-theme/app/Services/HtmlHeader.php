<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Roots\WPConfig\Config;

class HtmlHeader
{
    const HOUR_IN_SECONDS = 3600;

    public function getContent(): string
    {
        return Cache::get('html_header', fn() => $this->loadAndCache());
    }

    public function loadAndCache(): string
    {
        $content = file_get_contents(Config::get('HTML_HEADER_URL') . "/404-menu/?hide-daj-na-to=T&cb=" . rand(1, 100000000), false, stream_context_create(array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        )));

        preg_match('/<!-- START HEADER_WIDGET -->(.*)<!-- END HEADER_WIDGET -->/ms', $content, $matches);

        $content = $matches[1] ?? '';

        Cache::put('html_header', $content, self::HOUR_IN_SECONDS);

        return $content;
    }
}
