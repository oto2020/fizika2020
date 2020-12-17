<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\School;
use App\Section;
use App\User;
use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SchoolController extends Controller
{
    public function schoolPage() {
        $errors = [];

        try {
            $user = User::get();
            $role = UserRole::getByUser($user);
        }
        catch (\Exception $e) {
            $errors[]= $e->getMessage();
            $user = null;
            $role = null;
        }

        try {
            $school = School::getByUser($user);
        }
        catch (\Exception $e) {
            $errors[]= $e->getMessage();
            $school = null;
        }

        try {
            $sections = Section::getAllSections();
        }
        catch (\Exception $e) {
            $errors[]= $e->getMessage();
            $sections = null;
        }

        // Сохраняем ошибки в сессию
        Session::put('session_errors', $errors);

        return view('schoolpage', compact('user', 'role', 'school', 'sections'));
    }
}
