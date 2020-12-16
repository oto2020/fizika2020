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
                'uri' => '7-class',
                'school_id' => 1
            ]);
        } catch (\Exception $exc) {
            echo $exc->getMessage() . PHP_EOL;
        }

        try {
            DB::table('sections')->insert([
                'id' => 2,
                'name' => '8 класс',
                'uri' => '8-class',
                'school_id' => 1
            ]);
        } catch (\Exception $exc) {
            echo $exc->getMessage() . PHP_EOL;
        }

        try {
            DB::table('sections')->insert([
                'id' => 3,
                'name' => '9 класс',
                'uri' => '9-class',
                'school_id' => 1
            ]);
        } catch (\Exception $exc) {
            echo $exc->getMessage() . PHP_EOL;
        }

        try {
            DB::table('sections')->insert([
                'id' => 4,
                'name' => '10 класс',
                'uri' => '10-class',
                'school_id' => 1
            ]);
        } catch (\Exception $exc) {
            echo $exc->getMessage() . PHP_EOL;
        }

        try {
            DB::table('sections')->insert([
                'id' => 5,
                'name' => '11 класс',
                'uri' => '11-class',
                'school_id' => 1
            ]);
        } catch (\Exception $exc) {
            echo $exc->getMessage() . PHP_EOL;
        }
    }
}
