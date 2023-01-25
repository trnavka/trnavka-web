<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDarujmePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('darujme_payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_id');
            $table->string('name');
            $table->string('surname');
            $table->string('email');
            $table->string('variable_symbol');
            $table->string('periodicity');
            $table->integer('value');
            $table->string('payment_type');
            $table->string('campaign');
            $table->dateTime('received_at');
            $table->dateTime('registered_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('darujme_payments');
    }
}
