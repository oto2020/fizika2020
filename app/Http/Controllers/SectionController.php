<?php

namespace App\Http\Controllers;

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
    public function showSectionPage($schoolUri, $sectionUri) // где section - это url раздела
    {
        // получим пользователя, его роль и школу
        $user = User::get();
        $role = $user!==null ? UserRole::getByUserId($user->id) : null;
        $school = School::getByUri($schoolUri);

        // ДЛЯ ВЕРХНЕГО МЕНЮ -- СПИСОК РАЗДЕЛОВ (ГЛАВНАЯ, 7 КЛАСС, 8 КЛАСС И ТД,)
        $sections = Section::getSectionsBySchoolId($school->id);

        // Текущий раздел по id школы и uri раздела
        $section = Section::getCurrentSection($school->id, $sectionUri);
        dd($section);
//        // получим пользователя и его роль
//        $user = Auth::user();
//        $role = $this->getRole($user);
//
//        // ДЛЯ ВЕРХНЕГО МЕНЮ -- СПИСОК РАЗДЕЛОВ (ГЛАВНАЯ, 7 КЛАСС, 8 КЛАСС И ТД,)
//        $sections = $this->getSections();
//        // Текущий раздел
//        $section = $this->getSection($sectionURL);
//        // Уроки текущего раздела
//        $lessons = $this->getLessons($section->id);
//        if ($sectionURL == 'main') {
//            // КОНТЕНТ Главной страницы
//            $lesson = $this->getLesson('glavnaya-stranica');
//            $this->mylog('info', 'Зашел на Главную страницу');
//            return view('mainpage', compact('sections', 'section', 'lessons', 'lesson', 'user', 'role'));
//        }
//        $this->mylog('info', 'Зашел на страницу раздела /' . $sectionURL);
        return view('sectionpage', compact('sections', 'section', 'lessons', 'user', 'role'));
    }

}
