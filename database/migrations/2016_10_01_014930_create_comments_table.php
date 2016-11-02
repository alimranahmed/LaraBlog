<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->text('content');
            $table->integer('article_id')->unsigned();
            $table->foreign('article_id')
                ->references('id')
                ->on('articles')
                ->onDelete('cascade');
            $table->integer('reader_id')->unsigned()->nullable();
            $table->foreign('reader_id')
                ->references('id')
                ->on('readers');
            $table->integer('address_id')->unsigned()->nullable();
            $table->foreign('address_id')
                ->references('id')
                ->on('addresses');
            $table->integer('parent_comment_id')->unsigned()->nullable();
            $table->foreign('parent_comment_id')
                ->references('id')
                ->on('comments');
            $table->integer('is_published')->unsigned()->default(0);
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
}
