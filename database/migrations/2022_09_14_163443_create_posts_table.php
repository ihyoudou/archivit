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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('reddit_id')->unique()->nullable(false);
            $table->string('title')->default(null)->nullable(false);
            $table->longText('selftext')->nullable(true);
            $table->unsignedBigInteger('author_id')->unsigned();
            $table->foreign('author_id')->references('id')->on('authors')->oncascade('delete');
            $table->string('permalink')->nullable(false);
            $table->enum('media', ['image', 'video'])->nullable(true);
            $table->integer('upvotes')->default(0);
            $table->integer('downvotes')->default(0);
            $table->boolean('locked')->default(false);
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
};
