<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->foreignId('section_id')->references('id')->on('sections'); // к какому разделу сайта относится
            $table->foreignId('themes_id')->references('id')->on('themes');    // к какому разделу физики относится
            $table->foreignId('author')->references('id')->on('users');        // автор статьи


            $table->string('name'); // название урока
            //$table->date('date');
            $table->string('previewText', 500)->nullable();  // текст превью
            $table->string('uri');                                  // составная часть url
            $table->longText('content');                            // html-содержимое страницы
            $table->boolean('is_deleted')->default(false);    // помечено удалённым

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
        Schema::dropIfExists('lessons');
    }
}
