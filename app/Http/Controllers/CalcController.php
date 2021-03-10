<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\File as FileAlias;

class CalcController extends Controller
{
    function calcPage()
    {
        // массив с путями к JSON-содержимому
        $unitsPath = Storage::allFiles('public/calculators');
        // массив с содержимым
        $units=[];
        foreach($unitsPath as $path)
        {
            $units[]= json_decode(Storage::get($path)); // dd($units);
        }

        return view('calcpage', compact('units'));
    }
}
