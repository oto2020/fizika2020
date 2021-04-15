<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Logging;
use App\School;
use App\SchoolClass;
use App\Section;
use App\Themes;
use App\User;
use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SchoolController extends Controller
{
    // подготавливает данные для отображения главной страницы конкретной школы
    public function showMainPage($schoolUri)
    {
        // получим пользователя, его роль, школу и класс
        $user = User::get();
        $role = $user!==null ? UserRole::getById($user->user_role_id) : null;
        $school = School::getByUri($schoolUri);
        $class = $user!==null ? SchoolClass::getById($user->school_class_id) : null;

        // ДЛЯ ВЕРХНЕГО МЕНЮ -- СПИСОК РАЗДЕЛОВ (ГЛАВНАЯ, 7 КЛАСС, 8 КЛАСС И ТД,)
        $sections = Section::getSectionsBySchoolId($school->id);

        // Для содержимого
        $themes = Themes::getAllThemes();
        return view('mainpage', compact('sections', 'user', 'role', 'school', 'class', 'themes'));
    }


    // Редактирование html-содержимого главной страницы школы
    public function editMainPage($schoolUri)
    {
        // получим пользователя, его роль, школу и класс
        $user = User::get();
        $role = $user!==null ? UserRole::getById($user->user_role_id) : null;
        $school = School::getByUri($schoolUri);

        if ($user == null || $role->level < 60) {
            return redirect('/' . $schoolUri)->with('session_error', 'Только администратор может редактировать это!');
        }

        Logging::mylog('warning', 'Зашел на страницу редактирования главной страницы школы: ' . $school->uri );
        return view('editmainpage', compact('user', 'role', 'school'));
    }

    // Редактирование (update) html-содержимого главной страницы школы
    public function editMainPagePOST(Request $request)
    {
        $schoolId = $request->school_id;        // id школы, которой будем обновлять поле 'content'
        $htmlContent = $request->html_content;  // контент, который будем заливать
        $back_url = $request->back_url;         // url, на который редиректимся после апдейта
        // dd($htmlContent);

        // Обновляем контент Главной страницы школы с id равным $schoolId
        School::updateContent($schoolId, $htmlContent);

        Logging::mylog('warning', 'Редактирование главной страницы школы с id: ' . $schoolId);
        // редирект на Главную страницу школы
        return redirect($back_url)->with('message', 'Страница успешно отредактирована!');
    }






}
