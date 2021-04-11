<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {

            $table->bigIncrements('id')->unsigned();
            $table->foreignId('lesson_id')->references('id')->on('lessons');    // к какому уроку относится тест
            $table->foreignId('author_id')->references('id')->on('users');      // автор теста

            $table->string('name');                                     // название теста
            $table->string('preview_text', 500)->nullable();     // превью, о чем тест
            $table->string('uri');                                      // составная часть url теста

            $table->boolean('is_deleted')->default(false);      // пометка "удалено"

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
        Schema::dropIfExists('test1_tests');
    }
}
