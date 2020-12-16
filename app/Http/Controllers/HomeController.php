<?php

namespace App\Http\Controllers;

use App\Section;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            $user = null;
            $role = null;
        }
        try {
            $sections = Section::getAllSections();
        }
        catch (\Exception $e) {
            $sections = null;
        }
        return view('home', compact('user', 'role', 'sections'));
    }
}
