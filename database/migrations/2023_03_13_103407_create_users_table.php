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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname')->nullable();
            $table->string('patronymic')->nullable();
            $table->string('login');
            $table->unsignedBigInteger('status_id')->default(1);
            $table->unsignedBigInteger('group_id')->nullable();
            $table->string('password');
            $table->string('path')->nullable();
            $table->string('api_token')->nullable();
            $table->timestamps();

            $table->foreign('status_id')->references('id')->on('users_status');
            $table->foreign('group_id')->references('id')->on('users_group');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
