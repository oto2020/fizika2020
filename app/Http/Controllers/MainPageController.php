<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainPageController extends Controller
{
    // Главная страница
    public function showMainPage()
    {
        // получим пользователя и его роль
        $user = Auth::user();
        $role = $this->getRole($user);

        // ДЛЯ ВЕРХНЕГО МЕНЮ -- СПИСОК РАЗДЕЛОВ (ГЛАВНАЯ, 7 КЛАСС, 8 КЛАСС И ТД,)
        $sections = $this->getSections();

        return view('mainpage', compact('sections', 'user', 'role'));
    }
}
