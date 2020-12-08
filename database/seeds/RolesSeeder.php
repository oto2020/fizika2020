<?php

use Illuminate\Database\Seeder;
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

        try {
            DB::table('user_roles')->insert([
                'id' => 2,
                'name' => 'Администратор школы',
                'level' => '80',
                'description' => 'Администратор школы: управляет всеми учителями, классами, уроками и другими пользователями своей школы в Панели управления школой.',
            ]);
        } catch (\Exception $exc) {
            echo $exc->getMessage() . PHP_EOL;
        }

        try {
            DB::table('user_roles')->insert([
                'id' => 3,
                'name' => 'Учитель',
                'level' => '60',
                'description' => 'Учитель: может добавлять и редактировать уроки, тесты, контрольные и самостоятельные работы, управляет учениками из своих классов. Составляет план обучения на год в Панели управления классами.',
            ]);
        } catch (\Exception $exc) {
            echo $exc->getMessage() . PHP_EOL;
        }

        try {
            DB::table('user_roles')->insert([
                'id' => 4,
                'name' => 'Учитель',
                'level' => '60',
                'description' => 'Учитель: может добавлять и редактировать уроки, тесты, контрольные и самостоятельные работы, управляет учениками из своих классов. Составляет план обучения на год в Панели управления классами.',
            ]);
        } catch (\Exception $exc) {
            echo $exc->getMessage() . PHP_EOL;
        }

        try {
            DB::table('user_roles')->insert([
                'id' => 5,
                'name' => 'Ученик школы',
                'level' => '40',
                'description' => 'Ученик школы: проходит индивидуальный План обучения, составленный учителем и наблюдает свой прогресс, может оставлять комментарии',
            ]);
        } catch (\Exception $exc) {
            echo $exc->getMessage() . PHP_EOL;
        }

        try {
            DB::table('user_roles')->insert([
                'id' => 6,
                'name' => 'Анонимный ученик',
                'level' => '20',
                'description' => 'Анонимный ученик: принадлежит сам себе, проходит базовый индивидуальный План обучения и наблюдает свой прогресс.',
            ]);
        } catch (\Exception $exc) {
            echo $exc->getMessage() . PHP_EOL;
        }
    }
}
