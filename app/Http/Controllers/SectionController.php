<?php

namespace App\Http\Controllers;

use App\Lesson;
use App\Logging;
use App\School;
use App\Section;
use App\User;
use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SectionController extends Controller
{


    // страница с каким-либо разделом (Например: 7-class)
    public function showSectionPage($schoolUri, $sectionUri)
    {
        // получим пользователя, его роль и школу
        $user = User::get();
        $role = $user!==null ? UserRole::getById($user->user_role_id) : null;
        $school = School::getByUri($schoolUri);

        // ДЛЯ ВЕРХНЕГО МЕНЮ -- СПИСОК РАЗДЕЛОВ (ГЛАВНАЯ, 7 КЛАСС, 8 КЛАСС И ТД,)
        $sections = Section::getSectionsBySchoolId($school->id);

        // Текущий раздел по id школы и uri раздела
        $section = Section::getCurrentSection($school->id, $sectionUri);

        // Уроки текущего раздела
        $lessons = Lesson::getLessonsInfo($section->id);
        Logging::mylog('info', 'Зашел на страницу раздела /' . $schoolUri . '/' . $sectionUri);
        return view('sectionpage', compact('user', 'role', 'school', 'sections', 'section', 'lessons'));
    }

}
