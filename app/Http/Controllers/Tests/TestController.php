<?php

namespace App\Http\Controllers\Tests;

use App\Http\Controllers\Controller;
use App\SchoolClass;
use App\User;
use App\UserRole;
use Illuminate\Http\Request;

class TestController extends Controller
{

    // Тестовая страница
    public function testPage()
    {
        // получим пользователя, его роль, школу и класс
        $user = User::get();
        $role = $user!==null ? UserRole::getById($user->user_role_id) : null;
        $class = $user!==null ? SchoolClass::getById($user->school_class_id) : null;


        return view('tests.test');
    }

    public function testAjaxPost(Request $request)
    {
        return "Ну получил я эти ваши " . $request->login . ' и ' . $request->password;
    }


//    // Тестовая страница
//    public function testPage()
//    {
//        // получим пользователя, его роль, школу и класс
//        $user = User::get();
//        $role = $user!==null ? UserRole::getById($user->user_role_id) : null;
//        $class = $user!==null ? SchoolClass::getById($user->school_class_id) : null;
//
//
//        if($user == null) return redirect()->back()->with('session_error', 'Только авторизованный пользователь может загружать картинки');
//        $userFirstName = explode(' ', $user->name)[0];  // первая часть имени (бьем на массив по разделителю ' ' и выбираем первый элемент)
//
//        // Формируем prependName
//        $prependName = 'img_' . $user->id. '_' . $userFirstName . '_' . date('Y.m.d_H-i-s_'); // подготавливаем начало имени, под которым будет сохранено изображение
//
//        return view('tests.test', compact('prependName'));
//    }
//
//    public function testAjaxPost(Request $request)
//    {
//        return "Ну получил я эти ваши " . $request->login . ' и ' . $request->password;
//    }
}
