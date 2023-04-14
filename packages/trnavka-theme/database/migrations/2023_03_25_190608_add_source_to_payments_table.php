<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddSourceToPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('darujme_payments', function (Blueprint $table) {
            $table->string('source');
        });

        DB::statement("UPDATE `wp_darujme_payments` SET `source` = 'trnavka'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('darujme_payments', function (Blueprint $table) {
            $table->dropColumn('source');
        });
    }
}
