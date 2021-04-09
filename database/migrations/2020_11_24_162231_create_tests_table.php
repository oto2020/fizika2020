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
            $table->foreignId('lesson_id')->references('id')->on('lessons');
            $table->foreignId('user_id')->references('id')->on('users');

            $table->string('name');
            $table->string('preview_text', 500)->nullable();

            $table->string('uri');
            $table->string('full_uri');

            $table->boolean('is_deleted')->default(false);
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
