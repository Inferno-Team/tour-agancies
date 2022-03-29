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
        Schema::table('tour_users', function (Blueprint $table) {
            $table->string('payment_code')->unique();
            $table->enum('payment_method', ['mobile_cash', 'transaction']);
            $table->enum('approved', ['yes', 'no', 'waiting'])->default('waiting');
            $table->integer('seat_number')->nullable();
            $table->unique(['seat_number', 'tour_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
