<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Абстрактный нулевой класс для администраторов и учителей
        try {
            DB::table('school_classes')->insert([
                'id' => 1,

                'school_id' => 1,  // Базовая школа
                'teacher_name' => 'null', // нет школьного учителя

                'name' => 'Нулевой класс', // Пользователи, ссылающиеся на этот класс не являются реальными учениками. Это учителя или админы
                'uri' => 'null_class',     // Нулевой школьный класс

                'created_at' => now(),
                'updated_at' => null,
            ]);
        } catch (\Exception $exc) {
            echo $exc->getMessage() . PHP_EOL;
        }
    }
}
