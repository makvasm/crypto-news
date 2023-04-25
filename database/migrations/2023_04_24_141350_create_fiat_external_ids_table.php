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
        Schema::create('fiat_external_ids', function (Blueprint $table) {
            $table->uuid('id')
                  ->primary();
            $table->uuid('fiat_id');
            $table->foreign('fiat_id')
                  ->references('id')
                  ->on('fiats')
                  ->cascadeOnDelete();
            $table->string('value');
            $table->string('platform');
            $table->unique([
                'fiat_id',
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
        Schema::dropIfExists('fiat_external_ids');
    }
};
