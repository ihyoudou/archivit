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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();

            $table->string("rid")->unique()->nullable(false);
            $table->string('parent_id')->nullable(true);
            $table->longText('body');

            $table->unsignedBigInteger('reddit_post_id')->unsigned();
            $table->foreign('reddit_post_id')
                ->references('id')
                ->on('posts')
                ->onDelete('cascade');

            $table->unsignedBigInteger('author_id')->unsigned();
            $table->foreign('author_id')
                ->references('id')
                ->on('authors')
                ->onDelete('cascade');

            $table->integer('upvotes')->default(0);
            $table->integer('downvotes')->default(0);
            $table->float('score')->default(0);

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
        Schema::dropIfExists('comments');
    }
};
