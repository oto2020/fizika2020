<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // id, school_id, name, uri, teacher_name, classroom_teacher_name
    public function up()
    {
        Schema::create('school_classes', function (Blueprint $table) {

            // TODO: Создать абстрактный "нулевой класс", школа: базовая школа, учитель: Владелец сайта. Такой класс обрабатываться НЕ БУДЕТ
            $table->bigIncrements('id')->unsigned();
            $table->foreignId('school_id')->references('id')->on('schools');  // школа

            $table->string('name');                     // название класса, например: 7-А
            $table->string('uri');                      // uri класса, например: 7a
            $table->string('teacher_name')->nullable(); // имя учителя

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
        Schema::dropIfExists('school_classes');
    }
}
