<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class School extends Model
{
    public static function getByUser($user)
    {
        try {
            $role = DB::table('schools')
                ->select('id', 'name', 'uri', 'full_name', 'geo_address')
                ->where('id', '=', $user->school_id)
                ->get()[0];
        } catch (\Exception $e) {
            // если при определении шклолы возникают проблемы -- определяется базовая школа.
            $role = DB::table('schools')
                ->select('id', 'name', 'uri', 'full_name', 'geo_address')
                ->where('id', '=', 1)
                ->get()[0];
        }
        return $role;
    }
}
