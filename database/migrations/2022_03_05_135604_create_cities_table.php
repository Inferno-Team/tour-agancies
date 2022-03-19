<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        DB::table('cities')->insert([
            'name' => 'Aleppo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('cities')->insert([
            'name' => 'Damascus',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('cities')->insert([
            'name' => 'Latakia',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('cities')->insert([
            'name' => 'Homs',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('cities')->insert([
            'name' => 'Hama',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        /**
         * Reverse the migrations.
         *
         * @return void
         */
    }
    public function down()
    {
        Schema::dropIfExists('cities');
    }
};
