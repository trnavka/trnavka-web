<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeCampaignMetaboxId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("UPDATE `wp_postmeta` SET `meta_key` = 'App_Metabox_CampaignMetabox' WHERE `meta_key` = 'dajnato_campaign'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("UPDATE `wp_postmeta` SET `meta_key` = 'dajnato_campaign' WHERE `meta_key` = 'App_Metabox_CampaignMetabox'");
    }
}
