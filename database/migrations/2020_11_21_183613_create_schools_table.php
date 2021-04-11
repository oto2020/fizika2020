<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();

            $table->string('name');           // Название школы, например: "МБОУ СОШ № 31"
            $table->longText('content');      // html-содержимое Главной страницы
            $table->string('full_name');      // Полное название школы (юридическое наименование)
            $table->string('uri')->unique();  // Составная часть адреса, например: school31
            $table->string('geo_address');    // Географический адрес школы

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
        Schema::dropIfExists('schools');
    }
}
