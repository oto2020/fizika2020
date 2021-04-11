<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThemesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::table('themes')->insert([
                'id' => 1,
                'name' => 'Молекулярная физика',
                'preview_text' => 'Молекулярная физика это раздел, изучающий...',
                'uri' => 'mechanics',
                'created_at' => now(),
            ]);
        } catch (\Exception $exc) {
            echo $exc->getMessage() . PHP_EOL;
        }

        try {
            DB::table('themes')->insert([
                'id' => 2,
                'name' => 'Электричество и магнетизм',
                'preview_text' => 'Электричество и магнетизм это раздел физики, изучающий...',
                'uri' => 'electricity_and_magnetism',
                'created_at' => now(),
            ]);
        } catch (\Exception $exc) {
            echo $exc->getMessage() . PHP_EOL;
        }

        try {
            DB::table('themes')->insert([
                'id' => 3,
                'name' => 'Оптика',
                'preview_text' => 'Оптика это раздел физики, изучающий...',
                'uri' => 'optics',
                'created_at' => now(),
            ]);
        } catch (\Exception $exc) {
            echo $exc->getMessage() . PHP_EOL;
        }

        try {
            DB::table('themes')->insert([
                'id' => 4,
                'name' => 'Атомная и ядерная физика',
                'preview_text' => 'Атомная и ядерная физика это раздел, изучающий...',
                'uri' => 'atomic_and_nuclear',
                'created_at' => now(),
            ]);
        } catch (\Exception $exc) {
            echo $exc->getMessage() . PHP_EOL;
        }
    }
}
