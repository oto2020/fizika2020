<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Logging extends Model
{
    public static function mylog($level, $message)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $role = UserRole::getByUserId($user->id);
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
