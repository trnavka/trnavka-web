<?php

namespace App\Console\Commands;

use App\Services\Darujme;
use Illuminate\Console\Command;

class GenerateDarujmeStats extends Command
{
    protected $signature = 'generate:darujme-stats';

    protected $description = 'Generate stats from Darujme.sk';

    public function handle(Darujme $darujme)
    {
        $this->info('Generate Darujme.sk stats');

        $darujme->generateDonorCsv();

        $this->info('DONE.');
    }
}
