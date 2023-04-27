<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cryptocurrency_quotes', function (Blueprint $table) {
            $table->uuid('id')
                  ->primary();
            $table->float('price');
            $table->float('percent_change_hour')
                  ->nullable();
            $table->float('percent_change_day')
                  ->nullable();
            $table->float('percent_change_week')
                  ->nullable();
            $table->dateTime('last_updated')
                  ->nullable();
            $table->uuid('cryptocurrency_id');
            $table->foreign('cryptocurrency_id')
                  ->references('id')
                  ->on('cryptocurrencies');
            $table->uuid('fiat_id');
            $table->foreign('fiat_id')
                  ->references('id')
                  ->on('fiats');
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
        Schema::dropIfExists('cryptocurrency_quotes');
    }
};
