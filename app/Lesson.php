<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Lesson extends Model
{
    // Вытягивает из БД уроки, относящиеся к определённому разделу
    protected function getLessonsInfo($sectionID)
    {
        try {
            $lessons = DB::table('lessons')
                //TODO: проверить работоспособность этого запроса
                ->join('sections', 'lessons.section_id', '=', 'sections.id')    // ради uri раздела
                ->join('users', 'lessons.author_id', '=', 'users.id')           // ради имени автора
                ->select(
                    'sections.uri as section_uri',   // uri раздела (для построения полного пути к уроку)
                    'users.name as author_name',             // имя автора урока
                    'lessons.name as name',                 // название урока
                    'lessons.uri as uri',                   // uri урока (для построения полного пути к уроку)
                    'lessons.created_at as created_at',     // дата добавления урока
                    'lessons.preview_text as preview_text'  // текст превью урока
                )
                ->where('lessons.section_id', '=', $sectionID)
                ->where('lessons.is_deleted', '=', null)
                ->orderBy('lessons.id', 'asc')
                ->get();
        } catch (\Exception $e) {
            dd('Не удалось вытянуть из БД уроки. Обратитесь к администратору!', $e->getMessage());
        }
        return $lessons;
    }
}
