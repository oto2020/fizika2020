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

            // Роль пользователя: Администратор, Учитель, Ученик, Анонимный ученик
            $table->foreignId('user_role_id')->references('id')->on('user_roles');

            // Школа, к которой относится пользователь
            $table->foreignId('school_id')->references('id')->on('schools');

            // Школьный класс, например 7-А или "Учителя-администраторы"
            $table->foreignId('school_class_id')->references('id')->on('school_classes');


            // Имя пользователя (ФИО)
            $table->string('name');

            // E-mail
            $table->string('email')->unique();

            // Путь к аватарке
            $table->string('avatar_src')->default('/storage/img/avatars/default_avatar.png');

            // Пометка "удален", чтобы не удалять окончательно из базы
            $table->boolean('is_deleted')->default(false);

            // пароль пользователя (в зашифрованном виде)
            $table->string('password');

            // Токен, позволяющий входить без пароля (если была нажата галочка "Запомнить меня")
            $table->string('remember_token', 100)->nullable();

            // когда пользователь был подтверждён (по email, например)
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
