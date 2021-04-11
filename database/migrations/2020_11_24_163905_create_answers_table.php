<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_answers', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->foreignId('question_id')->references('id')->on('test_questions');  // к какому вопросу относится вариант ответа

            $table->string('name');         // содержимое варианта ответа
            $table->boolean('is_valid');    // является ли вариант ответа правильным

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
        Schema::dropIfExists('test_answers');
    }
}
