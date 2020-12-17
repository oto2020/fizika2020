<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Section extends Model
{
    public static function getAllSections()
    {
        try {
            $sections = DB::table('sections')
                ->select('id', 'name', 'uri')
                ->orderBy('id', 'asc')
                ->get();
        } catch (\Exception $e) {
            Throw new \Exception('Ошибка при получении разделов сайта' . (request('dev') ? PHP_EOL . $e->getMessage() : ''));
        }
        return $sections;
    }
}
