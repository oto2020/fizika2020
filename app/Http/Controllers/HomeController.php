<?php

namespace App\Http\Controllers;

use App\Section;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $errors = [];
        try {
            $user = Auth::user();
            $role = User::getRole($user);
        }
        catch (\Exception $e) {
            $errors[]= $e->getMessage();
            $user = null;
            $role = null;
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

        return view('home', compact('user', 'role', 'sections'));
    }
}
