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
        Schema::create('tes_agencyts', function (Blueprint $table) {
            $table->id();
            $table->string("name")->unique()->nullable()->default("Ali");
            $table->enum("type",['Manager','Normal','Admin']);
            $table->double("price");
            $table->foreignId("user_id")->nullable()->references("id")->on("users");
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
        Schema::dropIfExists('tes_agencyts');
    }
};
