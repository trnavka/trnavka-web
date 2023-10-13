<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dajnato_form_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('campaign_id');
            $table->integer('value');
            $table->string('payment_method_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->boolean('expenses');
            $table->boolean('info');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dajnato_form_submissions');
    }
};
