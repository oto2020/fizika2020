<?php

namespace App\Http\Controllers;

use App\Logging;
use App\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // Страница добавления картинки на сайт
    public function imgUploadPage()
    {
        Logging::mylog('warning', 'Зашел на страницу загрузки картинок');

        // Подготовим информаицю для формирования текста ПЕРЕД(prepend) именем картинки
        $user = User::get();                                    // текущий пользователь

        if($user == null) return redirect()->back()->with('session_error', 'Только авторизованный пользователь может загружать картинки');
        $userFirstName = explode(' ', $user->name)[0];  // первая часть имени (бьем на массив по разделителю ' ' и выбираем первый элемент)

        // Формируем prependName
        $prependName = 'img_' . $user->id. '_' . $userFirstName . '_' . date('Y.m.d_H-i-s_'); // подготавливаем начало имени, под которым будет сохранено изображение

        // страница загрузки картинок
        return view('img.upload', compact('prependName'));
    }

    //Загружает картинку на сайт
    public function imgUploadPOST(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->hasFile('images')) {//echo 'один файл точно есть';
                // Получаем начало имени из $request
                $prependName = $request->prepend_name;
                // сформируем массив будущих путей файла
                $filePaths = [];
                $i = 1;
                foreach ($request->images as $file)
                {
                    // Имя, под которым будет сохранен файл на сервере
                    $fileName = $prependName . '_' . $i . '.' . $file->getClientOriginalExtension();

                    // Сохранение файла в 'storage/app/public/img/uploaded/...'
                    Storage::putFileAs('/public/img/uploaded/', $file, $fileName, 'public');

                    // заполняем массив с путями картинок относительно папки public при условии,
                    // что у нас выполнена команда php artisan storage:link.
                    // Эта команда создаёт ссылку /public/storage на '/storage/app/public'
                    $filePaths[]= '/storage/img/uploaded/' . $fileName;

                    // Логгирование
                    Logging::mylog('warning', 'Загрузил на сайт картинку: ' . $fileName);
                    $i++;
                }
                // Страница, которая показывает список загруженных картинок на сервер.
                return view('img.show_uploaded', compact('filePaths'));
            } else {
                // Возвращаемся обратно на страницу загрузки с ошибкой
                return redirect('/img_upload')->with('session_error', 'Выберите файл (файлы)');
            }
        }
    }
}


//// отобразим сообщение об успешной загрузке файла
//echo '<hr>Файл ' . $i . ' [' . $futureFileName . '] успешно загружен!<br>';
////echo htmlspecialchars('<img src="/storage/img/' . $futureFileName . '" class="img-fluid" alt="Картинка не найдена">');
//echo '<br><div id="img_' . $i . '"><img src="/storage/img/' . $futureFileName . '" class="img-fluid" width="150px" alt="Картинка не найдена"></div><br>';
////                    echo '<textarea rows="2" cols="97" id="cont_' . $i . '"></textarea>';
////                    echo '<script>document.getElementById("cont_' . $i . '").value = document.getElementById("img_'.$i.'").innerHTML;</script>';
////echo '<br>Скопируйте ссылку и добавьте изображение с помощью соответсвующей кнопки в CKEditor.';
//echo '<br>Ссылка на файл:<br>';
//echo '<textarea rows="2" cols="97" id="cont_' . $i . '">';
//echo '/storage/img/' . $futureFileName;
//echo '</textarea><br>';
//echo '<button onclick="copyToClipBoard_' . $i . '()">Копировать в буфер обмена</button>';
//
//// подключаем обработчик по клику на кнопку "Копировать в буфер обмена"
//echo '
//                    <script>
//                        function copyToClipBoard_' . $i . '() {
//                            let copyText = document.getElementById(\'cont_' . $i . '\');
//                            copyText.select();
//                            document.execCommand("copy");
//                            alert("Скопирована ссылка: " + copyText.value + "\n\nИспользуйте её как url при размещении изображения на сайте.");
//                        }
//                    </script>';
