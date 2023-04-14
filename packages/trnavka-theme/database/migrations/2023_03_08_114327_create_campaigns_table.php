<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('darujme_campaigns', function (
            Blueprint $table
        ) {
            $table->id();
            $table->string('name');
            $table->string('authoritative_name');
            $table->unique('name');
        });

        Schema::table('darujme_payments', function (
            Blueprint $table
        ) {
            $table->index('campaign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('darujme_campaigns');
    }
}
