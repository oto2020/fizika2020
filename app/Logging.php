<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Logging
{
    public static function mylog($level, $message)
    {
        if (Auth::check()) {
            $user = User::get();
            $role = UserRole::getById($user->user_role_id);
            $school = School::getById($user->school_id);
            $class = SchoolClass::getById($user->school_class_id);
            $message =
                $role->name . ', ' .
                $school->name . ', ' .
                $class->name . ', ' .
                $user->name .
                '(' . $user->email . ')' .
                '[' . $_SERVER["REMOTE_ADDR"] . '] ' .
                $message;
        } else {
            $message = 'Аноним' .
                '[' . $_SERVER["REMOTE_ADDR"] . '] ' .
                $message;
        }
        if ($level === 'info') Log::info($message);
        if ($level === 'warning') Log::warning($message);
        if ($level === 'alert') Log::alert($message);
    }
}
