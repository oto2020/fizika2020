<?php

use Illuminate\Database\Seeder;

class SectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        try {
            DB::table('sections')->insert([
                'id' => 1,
                'name' => '7 класс',
                'url' => '7-class',
                'school_id' => 1
            ]);
        } catch (\Exception $exc) {
            echo 'Warning: наверное уже существует!' . $exc->getMessage() . PHP_EOL;
        }

        try {
            DB::table('sections')->insert([
                'id' => 2,
                'name' => '8 класс',
                'url' => '8-class',
                'school_id' => 1
            ]);
        } catch (\Exception $exc) {
            echo 'Warning: наверное уже существует!' . $exc->getMessage() . PHP_EOL;
        }

        try {
            DB::table('sections')->insert([
                'id' => 3,
                'name' => '9 класс',
                'url' => '9-class',
                'school_id' => 1
            ]);
        } catch (\Exception $exc) {
            echo 'Warning: наверное уже существует!' . $exc->getMessage() . PHP_EOL;
        }

        try {
            DB::table('sections')->insert([
                'id' => 4,
                'name' => '10 класс',
                'url' => '10-class'
            ]);
        } catch (\Exception $exc) {
            echo 'Warning: наверное уже существует!' . $exc->getMessage() . PHP_EOL;
        }

        try {
            DB::table('sections')->insert([
                'id' => 5,
                'name' => '11 класс',
                'url' => '11-class',
                'school_id' => 1
            ]);
        } catch (\Exception $exc) {
            echo $exc->getMessage() . PHP_EOL;
        }
    }
}
