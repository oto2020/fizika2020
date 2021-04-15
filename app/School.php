<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class School extends Model
{
    // Возвращает школу по её id
    public static function getById($schoolId)
    {
        try {
            $school = DB::table('schools')
                ->select('*')
                ->where('id', '=', $schoolId)
                ->get()[0];
        } catch (\Exception $e) {
            Throw new \Exception('Ошибка при определении школы по id: ' . PHP_EOL . $e->getMessage());
        }
        return $school;
    }

    // Возвращает школу по её uri
    public static function getByUri($schoolUri)
    {
        try {
            $school = DB::table('schools')
                ->select('*')
                ->where('uri', '=', $schoolUri)
                ->get()[0];
        } catch (\Exception $e) {
            Throw new \Exception('Ошибка при определении школы по uri: ' . PHP_EOL . $e->getMessage());
        }
        return $school;
    }
    // Обновляет контент главной страницы школы
    public static function updateContent ($schoolId, $htmlContent) {
        try {
            // проведём апдейт записи в таблице
            DB::table('schools')
                ->where('schoolId', '=', $schoolId)
                ->update(
                    [
                        'content' => $htmlContent,
                    ]);
        } catch (\Exception $e) {
            Throw new \Exception('Ошибка при обновлении контента главной страницы школы: ' . PHP_EOL . $e->getMessage());
        }
    }

}
