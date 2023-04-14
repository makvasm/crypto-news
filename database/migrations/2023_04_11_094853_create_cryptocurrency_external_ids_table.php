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
        Schema::create('cryptocurrency_external_ids', function (Blueprint $table) {
            $table->uuid('id')
                  ->primary();
            $table->uuid('cryptocurrency_id');
            $table->foreign('cryptocurrency_id')
                  ->references('id')
                  ->on('cryptocurrencies')
                  ->cascadeOnDelete();
            $table->string('value');
            $table->string('platform');
            $table->unique([
                'cryptocurrency_id',
                'value',
                'platform',
            ]);
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
        Schema::dropIfExists('cryptocurrency_external_ids');
    }
};
