<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\School;
use App\Section;
use App\User;
use App\UserRole;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    // подготавливает данные для отображения главной страницы конкретной школы
    public function showMainPage($schoolUri)
    {
        // получим пользователя, его роль и школу
        $user = User::get();
        $role = $user!==null ? UserRole::getByUserId($user->id) : null;
        $school = School::getByUri($schoolUri);

        // ДЛЯ ВЕРХНЕГО МЕНЮ -- СПИСОК РАЗДЕЛОВ (ГЛАВНАЯ, 7 КЛАСС, 8 КЛАСС И ТД,)
        $sections = Section::getSectionsBySchoolId($school->id);

        return view('mainpage', compact('sections', 'user', 'role', 'school'));
    }
}
