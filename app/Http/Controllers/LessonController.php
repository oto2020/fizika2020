<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Lesson;
use App\LessonComment;
use App\Logging;
use App\School;
use App\Section;
use App\Test;
use App\Themes;
use App\User;
use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LessonController extends Controller
{

    // страница с каким-либо уроком
    public function showLessonPage($schoolUri, $sectionUri, $lessonUri)
    {
        // получим пользователя, его роль и школу
        $user = User::get();
        $role = $user!==null ? UserRole::getById($user->user_role_id) : null;
        $school = School::getByUri($schoolUri);

        // ДЛЯ ВЕРХНЕГО МЕНЮ -- СПИСОК РАЗДЕЛОВ (ГЛАВНАЯ, 7 КЛАСС, 8 КЛАСС И ТД,)
        $sections = Section::getSectionsBySchoolId($school->id);

        // Текущий раздел по id школы и uri раздела
        $section = Section::getCurrentSection($school->id, $sectionUri);

        // Уроки текущего раздела (без контента)
        $lessons = Lesson::getLessonsInfo($section->id);

        // Текущий отображаемый урок
        $lesson = Lesson::getCurrentLesson($section->id, $lessonUri);
        //dump($lesson);

        // Тесты по уроку
        $tests = Test::getByLessonId($lesson->id);
        //dump($tests);

        // Комментарии к уроку
        $comments = LessonComment::getByLessonId($lesson->id);
        //dd($comments);


        Logging::mylog('info', 'Зашел на страницу урока /' . $schoolUri . '/' . $sectionUri . '/' . $lessonUri);
        return view('lessonpage', compact('user', 'role', 'school', 'sections', 'section', 'lessons', 'lesson', 'tests', 'comments'));
    }

    // Страница редактирования урока
    public function editLessonPage($schoolUri, $sectionUri, $lessonUri) {
        // получим пользователя, его роль и школу
        $user = User::get();
        $role = $user!==null ? UserRole::getById($user->user_role_id) : null;
        $school = School::getByUri($schoolUri);

        // ДЛЯ ВЕРХНЕГО МЕНЮ -- СПИСОК РАЗДЕЛОВ (ГЛАВНАЯ, 7 КЛАСС, 8 КЛАСС И ТД,)
        $sections = Section::getSectionsBySchoolId($school->id);

        // Текущий раздел по id школы и uri раздела
        $section = Section::getCurrentSection($school->id, $sectionUri);

        // Текущий редактируемый урок со всеми полями
        $lesson = Lesson::getCurrentLesson($section->id, $lessonUri);
        //dump($lesson);

        // Что можно изменить у урока помимо самого контента и других полей урока...?
        // Изменить раздел, к которому привязан урок -- уже есть section
        // Изменить тему, к которой относится урок
        $themes = Themes::getAllThemes();
        // Изменить автора -- Останется прежний

        return view('editlessonpage', compact('user', 'role', 'school', 'sections', 'section', 'lesson', 'themes'));
    }

    // Редактирование (update) html-содержимого урока
    public function editLessonPOST(Request $request)
    {
        //TODO: сделать проверку uri на уникальность в рамках всех уроков ЭТОГО раздела
        //TODO: менять back_url, ведь если изменится uri урока, то back_url остается прежним и это приведет к 404
        // dd($request->all());
        try {
            // проведём апдейт записи в таблице
            DB::table('lessons')
                ->where('id', '=', $request->lesson_id)
                ->update(
                    [
                        'name' => $request->lesson_name,
                        'uri' => $request->lesson_uri,
                        'section_id' => $request->section_id,
                        'themes_id' => $request->themes_id,
                        'preview_text' => $request->lesson_preview_text,
                        'content' => $request->lesson_content
                    ]);
        } catch (\Exception $e) {
            // редирект на страницу редактирования
            return redirect()->back()->with('session_error', 'При обновлении записи БД произошла ошибка' . (request('dev') ? PHP_EOL . $e->getMessage() : ''));
        }

        Logging::mylog('warning', 'Редактирование урока "'.$request->lesson_name.'" с id: ' . $request->lesson_id);
        // редирект на Главную страницу школы
        return redirect($request->back_url)->with('message', 'Страница успешно отредактирована!');
    }
}
