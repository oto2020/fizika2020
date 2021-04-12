<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class School extends Model
{
    // Возвращает школу по её id
    public static function getById($schoolId)
    {
        try {
            $school = DB::table('schools')
                ->select('*')
                ->where('id', '=', $schoolId)
                ->get()[0];
        } catch (\Exception $e) {
            Throw new \Exception('Ошибка при определении школы по id' . (request('dev') ? PHP_EOL . $e->getMessage() : ''));
        }
        return $school;
    }

    // Возвращает школу по её uri
    public static function getByUri($schoolUri)
    {
        try {
            $school = DB::table('schools')
                ->select('*')
                ->where('uri', '=', $schoolUri)
                ->get()[0];
        } catch (\Exception $e) {
            Throw new \Exception('Ошибка при определении школы по uri' . (request('dev') ? PHP_EOL . $e->getMessage() : ''));
        }
        return $school;
    }
}
