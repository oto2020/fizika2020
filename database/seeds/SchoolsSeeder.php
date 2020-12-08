<?php

use Illuminate\Database\Seeder;

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
                'name' => 'Базовая школа',
                'url' => 'base',
                'full_name' => 'Базовая школа. Содержащая базовый курс физики, от которого наследуются остальные школы.',
                'geo_address' => 'г. Симферополь, проспект Вернадского, 4',
                'created_at' => now(),
                'updated_at' => null,
            ]);
        } catch (\Exception $exc) {
            echo $exc->getMessage() . PHP_EOL;
        }
    }
}
