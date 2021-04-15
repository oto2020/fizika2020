<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Test extends Model
{
    // getByLessonId
    // Возвращает разделы, принадлежащие школе по id школы
    public static function getByLessonId($lessonId)
    {
        try {
            $sections = DB::table('tests')
                ->select('*')
                ->where('lesson_id', '=', $lessonId)
                ->get();
        } catch (\Exception $e) {
            Throw new \Exception('Ошибка при получении тестов по id урока: ' . PHP_EOL . $e->getMessage());
        }
        return $sections;
    }
}
