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
        Schema::create('tour_place_time_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->references('id')->on('tour_details');
            $table->foreignId('place_id')->references('id')->on('places');
            $table->foreignId('time_id')->references('id')->on('time_steps');
            $table->string('day');
            $table->unique(['tour_id', 'place_id', 'time_id', 'day']);
            // $table->foreignId('pt_id')->references('id')->on('place_time_models');
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
        Schema::dropIfExists('tour_time_place_models');
    }
};
