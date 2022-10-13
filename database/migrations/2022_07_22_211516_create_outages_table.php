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
        Schema::create('outages', function (Blueprint $table) {
            $table->id();
            $table->dateTime('start');
            $table->index('start');
            $table->dateTime('end');
            $table->index('end');
            $table->integer('cec_number')->nullable();
            $table->string('location');
            $table->index('location');
            $table->text('address');
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
        Schema::dropIfExists('outages');
    }
};
