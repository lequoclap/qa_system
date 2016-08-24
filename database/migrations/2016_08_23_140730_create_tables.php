<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $t) {
            $t->increments('id');
            $t->string('name');
            $t->string('email')->unique();
            $t->string('password');
            $t->rememberToken();
            $t->timestamps();
        });

        Schema::create('categories', function (Blueprint $t) {
            $t->increments('id');
            $t->string('name');
            $t->timestamps();
        });

        Schema::create('topics', function (Blueprint $t) {
            $t->increments('id');
            $t->unsignedInteger('user_id');
            $t->unsignedInteger('category_id');
            $t->string('title');
            $t->text('content');
            $t->string('tags');
            $t->timestamps();
            $t->foreign('user_id')->references('id')->on('users');
            $t->foreign('category_id')->references('id')->on('categories');
        });

        Schema::create('comments', function (Blueprint $t) {
            $t->increments('id');
            $t->unsignedInteger('user_id');
            $t->unsignedInteger('topic_id');
            $t->text('content');
            $t->timestamps();
            $t->foreign('user_id')->references('id')->on('users');
            $t->foreign('topic_id')->references('id')->on('topics');
        });


        Schema::create('votes', function (Blueprint $t) {
            $t->increments('id');
            $t->unsignedInteger('user_id');
            $t->boolean('type');
            $t->string('target');
            $t->unsignedInteger('topic_id')->nullable();
            $t->unsignedInteger('comment_id')->nullable();
            $t->timestamps();
            $t->foreign('user_id')->references('id')->on('users');
            $t->foreign('topic_id')->references('id')->on('topics');
            $t->foreign('comment_id')->references('id')->on('comments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('votes');
        Schema::drop('comments');
        Schema::drop('topics');
        Schema::drop('categories');
        Schema::drop('users');
    }
}
