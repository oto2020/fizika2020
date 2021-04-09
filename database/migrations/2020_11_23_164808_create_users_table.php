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
            $table->foreignId('user_role_id')->references('id')->on('user_roles');

            //$table->foreignId('school_id')->references('id')->on('schools');
            $table->string('name');
            $table->string('class_name')->nullable();
            $table->string('email');
            $table->string('avatar_src')->default('/storage/img/avatars/default_avatar.png');
            $table->boolean('is_deleted')->default(false);

            $table->string('password');
            $table->string('remember_token', 100)->nullable();

            $table->timestamp('verified_at')->nullable();
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
