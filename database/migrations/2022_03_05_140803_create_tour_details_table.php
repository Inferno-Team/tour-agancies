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
        Schema::create('tour_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agancy_id')->references('id')->on('agancies');
            $table->foreignId('city_id')->references('id')->on('cities');
            $table->double('cost')->default(0.0);
            $table->integer('seat_count')->default(0);
            $table->date('start_at')->nullable();
            $table->date('end_at')->nullable();
            $table->enum('type', ['event', 'tour']);
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
        Schema::table('tour_details', function (Blueprint $table) {
            $table->dropForeign(['agancy_id']);
            $table->dropForeign(['city_id']);
        });
        Schema::dropIfExists('tour_details');
    }
};
