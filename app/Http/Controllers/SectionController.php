<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SectionController extends Controller
{
    // Вытягивает из БД разделы сайта
    protected function getSections()
    {
        try {
            $sections = DB::table('sections')
                ->select('id', 'name', 'url', 'ico')
                ->orderBy('id', 'asc')
                ->get();
        } catch (\Exception $e) {
            dd('Не удалось вытянуть из БД разделы сайта. Обратитесь к администратору!', $e->getMessage());
        }
        return $sections;
    }

//    // страница с каким-либо разделом (Например: 7-class)
//    public function showSectionPage($sectionURL) // где section - это url раздела
//    {
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
//        return view('sectionpage', compact('sections', 'section', 'lessons', 'user', 'role'));
//    }

}
