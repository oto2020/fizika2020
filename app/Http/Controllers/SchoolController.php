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

class SchoolController extends Controller
{
    // подготавливает данные для отображения главной страницы конкретной школы
    public function showMainPage($schoolUri)
    {
        // получим пользователя, его роль, школу и класс
        $user = User::get();
        $role = $user!==null ? UserRole::getByUserId($user->id) : null;
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
        $role = $user!==null ? UserRole::getByUserId($user->id) : null;
        $school = School::getByUri($schoolUri);

        if ($user == null || $role->level < 60) {
            return redirect('/' . $schoolUri)->with('session_error', 'Только администратор может редактировать это!');
        }

        Logging::mylog('warning', 'Зашел на страницу редактирования главной страницы школы: ' . $school->uri );
        return view('editmainpage', compact('user', 'role', 'school'));
    }
}
