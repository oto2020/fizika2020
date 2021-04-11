<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Themes extends Model
{
    public static function getAllThemes()
    {
        try {
            $themes = DB::table('themes')
                ->select('*')
                ->get();
        } catch (\Exception $e) {
            Throw new \Exception('Ошибка при получении Разделов физики' . (request('dev') ? PHP_EOL . $e->getMessage() : ''));
        }
        return $themes;
    }
}
