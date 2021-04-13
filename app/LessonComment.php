<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LessonComment extends Model
{
    // Возвращает комментарии по id урока
    public static function getByLessonId($lessonId)
    {
        try {
            // отбираем из двух таблиц при соблюдении условия, что sections.school_id = schools.id
            $section = DB::table('lesson_comments')
                ->join('users', 'lesson_comments.user_id', '=', 'users.id') // ради получения пользователя
                ->select(
                    'users.name as user_name',
                    'users.avatar_src as avatar_src',
                    'lesson_comments.content as content',
                    'lesson_comments.created_at as created_at'
                )
                ->where('lesson_id', '=', $lessonId)
                ->get();
        } catch (\Exception $e) {
            Throw new \Exception('Ошибка при получении комментариев по id урока' . (request('dev') ? PHP_EOL . $e->getMessage() : ''));
        }
        return $section;
    }
}
