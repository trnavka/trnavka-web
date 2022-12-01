<?php

namespace App\Console\Commands;

use App\Services\HtmlHeader;
use Illuminate\Console\Command;

class UpdateHeader extends Command
{
    protected $signature = 'update:html-header';

    protected $description = 'Update static html header from main trnavka web';

    public function handle(HtmlHeader $htmlHeader)
    {
        $this->info('Updating header');

        $htmlHeader->loadAndCache();

        $this->info('DONE.');
    }
}
