<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_results', function (Blueprint $table) {

            $table->bigIncrements('id')->unsigned();

            $table->foreignId('test_id')->references('id')->on('tests'); // тест
            $table->foreignId('user_id')->references('id')->on('users'); // пользователь, который проходил тест

            $table->unsignedInteger('point'); // результат прохождения теста (в %)
            $table->longText('details');      // детальная информация о пройденном тесте

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
        Schema::dropIfExists('test_results');
    }
}
