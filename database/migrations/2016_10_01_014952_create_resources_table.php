<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name')->nullable();
            $table->text('content')->nullable();
            $table->integer('image_id')->unsigned()->nullable();
            $table->foreign('image_id')
                ->references('id')
                ->on('images');
            $table->integer('page_id')->unsigned()->nullable();
            $table->foreign('page_id')
                ->references('id')
                ->on('pages')
                ->onDelete('cascade');
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
        Schema::dropIfExists('resources');
    }
}
