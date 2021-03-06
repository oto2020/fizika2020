<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        // Владелец сайта:
        try {
            DB::table('users')->insert([
                'id' => 1,

                'user_role_id' => 1,    // admin
                'school_id' => 1,       // school0
                'school_class_id' => 1, // Нулевой класс
                'name' => 'Конюхова Антонина Евгеньевна',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('1234'), // ПАРОЛЬ УКАЗАН В КАЧЕСТВЕ ПРИМЕРА
                'created_at' => now(),
            ]);
        } catch (\Exception $exc) {
            echo $exc->getMessage() . PHP_EOL;
        }

//        // Демо-аккаунт владельца сайта
//        try {
//            DB::table('users')->insert([
//                'id' => 2,
//                'name' => 'Блыщик Владимир Фёдорович',
////                'avatar_src' => '/storage/img/AVATAR_ZAYAC.png',
//                'user_role_id' => 1,  // admin
//                'school_id' => 1, // base
//                'class_name' => null,
//                'email' => 'demo@gmail.com',
//                'verified_at' => null,
//                'password' => Hash::make('1234'), // ПАРОЛЬ УКАЗАН В КАЧЕСТВЕ ПРИМЕРА
//                'remember_token' => null,
//                'created_at' => now(),
//                'updated_at' => null,
//            ]);
//        } catch (\Exception $exc) {
//            echo $exc->getMessage() . PHP_EOL;
//        }
    }
}
