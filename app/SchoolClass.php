<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SchoolClass extends Model
{
    public static function getById($schoolClassId)
    {
        try {
            $school = DB::table('school_classes')
                ->select('*')
                ->where('id', '=', $schoolClassId)
                ->get()[0];
        } catch (\Exception $e) {
            Throw new \Exception('Ошибка при определении школьного класса по id' . (request('dev') ? PHP_EOL . $e->getMessage() : ''));
        }
        return $school;
    }
}
