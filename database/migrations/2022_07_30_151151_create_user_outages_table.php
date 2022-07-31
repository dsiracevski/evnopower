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
        Schema::create('user_outages', function (Blueprint $table) {
            $table->primary(['user_id', 'outage_id']);
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('outage_id')->references('id')->on('outages');
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
        Schema::dropIfExists('user_outages');
    }
};
