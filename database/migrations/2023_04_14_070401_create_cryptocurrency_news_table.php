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
        Schema::create('cryptocurrency_news', function (Blueprint $table) {
            $table->uuid('id')
                  ->primary();
            $table->uuid('cryptocurrency_id');
            $table->foreign('cryptocurrency_id')
                  ->references('id')
                  ->on('cryptocurrencies');
            $table->uuid('news_id');
            $table->foreign('news_id')
                  ->references('id')
                  ->on('news');
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
        Schema::dropIfExists('cryptocurrency_news');
    }
};
