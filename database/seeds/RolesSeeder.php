<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        try {
            DB::table('user_roles')->insert([
                'id' => 1,
                'name' => 'Администратор сайта',
                'level' => '100',
                'description' => 'Администратор сайта: управляет всеми школами, класами, уроками и другими пользователями в Панели управления сайтом.',
            ]);
        } catch (\Exception $exc) {
            echo $exc->getMessage() . PHP_EOL;
        }

//        try {
//            DB::table('user_roles')->insert([
//                'id' => 2,
//                'name' => 'Администратор школы',
//                'level' => '80',
//                'description' => 'Администратор школы: управляет всеми учителями, классами, уроками и другими пользователями своей школы в Панели управления школой.',
//            ]);
//        } catch (\Exception $exc) {
//            echo $exc->getMessage() . PHP_EOL;
//        }

        try {
            DB::table('user_roles')->insert([
                'id' => 2,
                'name' => 'Учитель-администратор',
                'level' => '60',
                'description' => 'Учитель-администратор: наполняет контентом уроки и тесты своей школы. Может управлять другими пользователями из своей школы,',
            ]);
        } catch (\Exception $exc) {
            echo $exc->getMessage() . PHP_EOL;
        }


        try {
            DB::table('user_roles')->insert([
                'id' => 3,
                'name' => 'Ученик школы',
                'level' => '40',
                'description' => 'Ученик школы: изучает уроки, проходит тесты, может оставлять комментарии к урокам.',
            ]);
        } catch (\Exception $exc) {
            echo $exc->getMessage() . PHP_EOL;
        }

        try {
            DB::table('user_roles')->insert([
                'id' => 5,
                'name' => 'Анонимный ученик',
                'level' => '20',
                'description' => 'Анонимный ученик: изучает уроки и тесты базовой программы.',
            ]);
        } catch (\Exception $exc) {
            echo $exc->getMessage() . PHP_EOL;
        }
    }
}
