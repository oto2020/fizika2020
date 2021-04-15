<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Lesson extends Model
{
    // Вытягивает из БД уроки, относящиеся к определённому разделу
    public static function getLessonsInfo($sectionID)
    {
        try {
            $lessons = DB::table('lessons')
                ->join('sections', 'lessons.section_id', '=', 'sections.id')    // ради uri раздела
                ->join('users', 'lessons.author_id', '=', 'users.id')           // ради имени автора
                ->join('themes', 'lessons.themes_id', '=', 'themes.id')         // ради имени и uri темы
                ->select(
                    'sections.uri as section_uri',   // uri раздела (для построения полного пути к уроку)
                    'users.name as author_name',             // имя автора урока
                    'themes.name as themes_name',            // название темы
                    'themes.uri as themes_uri',              // uri темы
                    'lessons.name as name',                  // название урока
                    'lessons.uri as uri',                    // uri урока (для построения полного пути к уроку)
                    'lessons.created_at as created_at',      // дата добавления урока
                    'lessons.updated_at as updated_at',      // дата обновления урока
                    'lessons.preview_text as preview_text',  // текст превью урока
                    'lessons.is_deleted as is_deleted'       // нужно ли отображать урок
                )
                ->where('lessons.section_id', '=', $sectionID)
                ->where('lessons.is_deleted', '=', 0)
                ->orderBy('lessons.id', 'asc')
                ->get();
        } catch (\Exception $e) {
            Throw new \Exception('Ошибка при получении уроков текущего раздела: ' . PHP_EOL . $e->getMessage());
        }
        return $lessons;
    }


    // Возвращает текущий раздел по id раздела и uri урока
    public static function getCurrentLesson($sectionId, $lessonUri)
    {
        try {
            $lesson = DB::table('lessons')
                ->join('sections', 'lessons.section_id', '=', 'sections.id')    // ради uri раздела
                ->join('users', 'lessons.author_id', '=', 'users.id')           // ради имени автора
                ->join('themes', 'lessons.themes_id', '=', 'themes.id')         // ради названия темы
                ->select(
                    'sections.uri as section_uri',   // uri раздела (для построения полного пути к уроку)
                    'users.name as author_name',             // имя автора урока
                    'themes.id as themes_id',                // id темы
                    'themes.name as themes_name',            // название темы
                    'themes.uri as themes_uri',              // uri темы
                    'lessons.id as id',                      // id урока
                    'lessons.section_id as section_id',      // id раздела
                    'lessons.name as name',                  // название урока
                    'lessons.content as content',            // html КОНТЕНТ
                    'lessons.uri as uri',                    // uri урока (для построения полного пути к уроку)
                    'lessons.created_at as created_at',      // дата добавления урока
                    'lessons.updated_at as updated_at',      // дата обновления урока
                    'lessons.preview_text as preview_text',  // текст превью урока
                    'lessons.is_deleted as is_deleted'       // нужно ли отображать урок
                )
                ->where('lessons.section_id', '=', $sectionId)
                ->where('lessons.uri', '=', $lessonUri)
                ->get()[0];
        } catch (\Exception $e) {
            Throw new \Exception('Ошибка при определении текущего урока: ' . PHP_EOL . $e->getMessage());
        }
        return $lesson;
    }

    // Возвращает полный путь к уроку по id урока (после редактирования мог изменить раздел и uri)
    public static function getFullUri($lessonId) {
        try {
            $uri = DB::table('lessons')
                ->join('sections', 'lessons.section_id', 'sections.id')
                ->join('schools', 'sections.school_id', '=', 'schools.id')
                ->where('lessons.id', '=', $lessonId)
                ->select(
                    'schools.uri as school_uri',
                    'sections.uri as section_uri',
                    'lessons.uri as lesson_uri'
                )
                ->get()[0];
        } catch (\Exception $e) {
            Throw new \Exception('Ошибка при формировании полного пути к уроку:  ' . PHP_EOL . $e->getMessage());
        }
        return '/' . $uri->school_uri . '/' . $uri->section_uri . '/' . $uri->lesson_uri;
    }

    // определяет, не занят ли uri в разделе. (Примечание: uri могут совпадать в разных разделах, однако в рамках одного раздела они должны различаться)
    public static function notFreeUriException ($checkedLessonUri, $sectionId) {
        // Получим uri всех уроков, относящих себя к разделу с $sectionId
        try {
            $lessons = DB::table('lessons')
                ->join('sections', 'lessons.section_id', '=', 'sections.id')
                ->select(
                    'lessons.id as lesson_id',
                    'lessons.uri as uri',
                    'lessons.name as name',
                    'sections.name as section_name'
                )
                ->where('section_id', '=', $sectionId)
                ->get();
        } catch (\Exception $e) {
            Throw new \Exception('Ошибка при определении свободности для uri урока в разделе с id: ' .$sectionId . ' ' . PHP_EOL . $e->getMessage());
        }
        // изначально считаем, что uri свободно
        $isFree = true;
        foreach ($lessons as $lesson)
        {
            if ($lesson->uri == $checkedLessonUri) {
                // найдено совпадение -- генерируем исключение
                Throw new \Exception ('"' . $checkedLessonUri . '" уже занят в выбранном разделе "'.
                    $lesson->section_name.'". Задайте другой uri для этого урока.');
            }
        }
        // если дошли сюда, значит всё ок, исключение не вылетело
    }

    // Обновляет урок
    public static function updateLesson($lesson_id, $name, $uri, $section_id, $themes_id, $preview_text, $content) {
        try {
            // проведём апдейт записи в таблице
            DB::table('lessons')
                ->where('id', '=', $lesson_id)
                ->update(
                    [
                        'name' => $name,
                        'uri' => $uri,
                        'section_id' => $section_id,
                        'themes_id' => $themes_id,
                        'preview_text' => $preview_text,
                        'content' => $content
                    ]);
        } catch (\Exception $e) {
            Throw new \Exception('Ошибка при обновлении страницы урока: ' . PHP_EOL . $e->getMessage());
        }
    }
}
