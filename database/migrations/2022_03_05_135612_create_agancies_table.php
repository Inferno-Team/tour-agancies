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
        Schema::create('agancies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('city_id')->references('id')->on('cities');
            $table->foreignId('manager_id')->unique()->references('id')->on('users');
            $table->string('location');
            $table->string('img_url')->nullable();
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
        Schema::dropIfExists('agancies');
    }
};
