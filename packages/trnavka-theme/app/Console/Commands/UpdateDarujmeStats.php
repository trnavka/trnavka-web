<?php

namespace App\Console\Commands;

use App\Services\Darujme;
use Illuminate\Console\Command;

class UpdateDarujmeStats extends Command
{
    protected $signature = 'update:darujme-stats';

    protected $description = 'Update stats from Darujme.sk';

    public function handle(Darujme $darujme)
    {
        $this->info('Updating Darujme.sk stats');

        $darujme->updatePayments();
        $darujme->updateCampaigns();

        $this->info('DONE.');
    }
}
