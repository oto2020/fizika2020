<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Lesson;
use App\LessonComment;
use App\Logging;
use App\School;
use App\Section;
use App\Test;
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
}
