<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id')->unsigned();
            $table->string('avatar_src');
            $table->foreignId('user_role_id')->references('id')->on('user_roles');
            $table->foreignId('school_id')->references('id')->on('schools');
            $table->string('name');
            $table->string('class_name');
            $table->string('email');
            $table->timestamp('verified_at');
            $table->string('password');
            $table->string('remember_token', 100);
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
}
