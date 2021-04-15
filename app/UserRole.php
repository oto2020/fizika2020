<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserRole extends Model
{
    // Возвращает роль пользователя по его id
    public static function getById($roleId)
    {
        $user = User::get();
        try {
            $role = DB::table('user_roles')
                ->select('id', 'name', 'level', 'description')
                ->where('id', '=', $roleId)
                ->get()[0];
        } catch (\Exception $e) {
            Throw new \Exception('Ошибка при определении роли пользователя: ' . PHP_EOL . $e->getMessage());
        }
        return $role;
    }

}
