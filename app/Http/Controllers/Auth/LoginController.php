<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Logging;
use App\Providers\RouteServiceProvider;
use App\School;
use App\User;
use App\UserRole;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        Logging::mylog('info', 'Попытка войти в систему под email: ' . $request->email);
        session(['login_email' => $request->email]);
        if (Auth::attempt(['email'=>$request->email, 'password'=>$request->password], ($request->remember == 'on')))
        {
            // Аутентификация успешна...
            Logging::mylog('info', 'Вошел в систему');

            // получим пользователя, его роль и школу
            $user = User::get();
            $role = $user!==null ? UserRole::getById($user->user_role_id) : null;
            $school = School::getById($user->school_id);

            return redirect('/'.$school->uri)->with('message', 'Школа ['.$school->name.']. Вы вошли в систему как ['.$role->name.']. '.$role->description);
        }
        Logging::mylog('warning', 'Неправильный логин или пароль при введённом email ' . $request->email);
        return redirect('/login')->with('session_error', 'Неправильный логин или пароль');
    }

    public function logout()
    {
        Logging::mylog('info', 'Вышел из системы');
        Auth::logout();
        return redirect()->back()->with('message', 'Вы зачем-то вышли.');
    }
}
