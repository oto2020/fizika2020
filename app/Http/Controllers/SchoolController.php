<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function schoolPage() {
        dd('school info');
        return view('schoolpage');
    }
}
