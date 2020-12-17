<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::table('schools')->insert([
                'id' => 1,
                'name' => 'Базовая домашняя школа',
                'uri' => 'home',
                'full_name' => 'Базовая школа. Содержит базовый курс физики для домашнего обучения учеников без привязки к какой-либо школе. От базовой школы наследуются остальные школы.',
                'geo_address' => 'г. Симферополь, проспект Вернадского, 4',
                'created_at' => now(),
                'updated_at' => null,
            ]);
        } catch (\Exception $exc) {
            echo $exc->getMessage() . PHP_EOL;
        }
    }
}
