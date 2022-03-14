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
            $table->string('title', 200);
            $table->string('slug', 200);
            $table->text('desc');
            $table->text('content');
            $table->string('thumbnail', 255);
            $table->enum('status', ['pending', 'public', 'trash']);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('post_cat_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('m_users');
            $table->foreign('post_cat_id')->references('id')->on('category_posts')->onDelete('cascade');
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
