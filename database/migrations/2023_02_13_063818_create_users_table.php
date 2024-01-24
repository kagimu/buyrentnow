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
            $table->string('socket_id')->nullable();
            $table->unsignedInteger('active')->default(1);
            $table->string('first_name')->default('null');
            $table->string('last_name')->default('null');
            $table->string('username')->unique;
            $table->string('email')->nullable();
            $table->string('password');
            $table->string('profile_pic')->nullable();
            $table->string('position')->nullable();
            $table->string('role')->nullable();
            $table->boolean('online')->default(false);
            $table->timestamp('last_login')->nullable();
            $table->timestamp('last_logout')->nullable();
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
        Schema::dropIfExists('users');
    }
};
