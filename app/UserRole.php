<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserRole extends Model
{
    public static function getByUser($user)
    {
        try {
            $role = DB::table('user_roles')
                ->select('id', 'name', 'level', 'description')
                ->where('id', '=', $user->user_role_id)
                ->get()[0];
        } catch (\Exception $e) {
            Throw new \Exception('Ошибка при определении роли пользователя' . (request('dev') ? PHP_EOL . $e->getMessage() : ''));
        }
        return $role;
    }
}
