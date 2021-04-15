<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Section extends Model
{
    // Возвращает разделы, принадлежащие школе по id школы
    public static function getSectionsBySchoolId($schoolId)
    {
        try {
            $sections = DB::table('sections')
                ->select('*')
                ->where('school_id', '=', $schoolId)
                ->get();
        } catch (\Exception $e) {
            Throw new \Exception('Ошибка при получении разделов сайта по id школы: ' . PHP_EOL . $e->getMessage());
        }
        return $sections;
    }

    // Возвращает раздел по id школы и uri раздела
    public static function getCurrentSection($schoolId, $sectionUri)
    {
        try {
            // отбираем из двух таблиц при соблюдении условия, что sections.school_id = schools.id
            $section = DB::table('sections')
                ->join('schools', 'sections.school_id','=','schools.id')
                ->select('sections.*')
                ->where('schools.id', '=', $schoolId)
                ->where('sections.uri', '=', $sectionUri)
                ->get()[0];
        } catch (\Exception $e) {
            Throw new \Exception('Ошибка при получении текущего раздела по id школы и uri раздела: ' . PHP_EOL . $e->getMessage());
        }
        return $section;
    }

}
