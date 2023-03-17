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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('table');
            $table->unsignedBigInteger('shift_workers');
            $table->dateTime('create_at')->default(now())->nullable();
            $table->string('status');
            $table->unsignedBigInteger('shift_id');
            $table->unsignedBigInteger('position_id')->nullable();
            $table->timestamps();

            $table->foreign('shift_workers')->references('id')->on('users');
            $table->foreign('shift_id')->references('id')->on('shifts');
            $table->foreign('position_id')->references('id')->on('position');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
