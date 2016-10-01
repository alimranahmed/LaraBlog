<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 10);
            $table->string('name')->index();
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('image_id')->unsigned()->nullable();
            $table->foreign('image_id')
                ->references('id')
                ->on('images')
                ->onDelete('cascade');
            $table->integer('is_active')->unsigned()->default(1);
            $table->dateTime('last_active')->nullable();
            $table->string('last_ip', 200)->nullable();
            $table->integer('location_id')->unsigned()->nullable();
            $table->foreign('location_id')
                ->references('id')
                ->on('locations')
                ->onDelete('cascade');
            $table->string('token')->nullable();
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
