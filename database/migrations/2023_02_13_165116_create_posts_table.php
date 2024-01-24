<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->text('desc');
            $table->text('title')->nullable();
            $table->string('owner')->nullable();
            $table->json('images');
            $table->string('video')->nullable();
            $table->string('cover_pic')->nullable();
            $table->text('location');
            $table->string('tag')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            
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
        Schema::dropIfExists('posts');
    }
}
