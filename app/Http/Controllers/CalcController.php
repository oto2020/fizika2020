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
        $calculatorsPath = Storage::allFiles('public/calculators');
        // массив с содержимым
        $calculators=[];
        foreach($calculatorsPath as $path)
        {
            $calculators[]= json_decode(Storage::get($path)); // dd($units);
        }
        return view('calcpage', compact('calculators'));
    }
}
