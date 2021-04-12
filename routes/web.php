<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
// Маршруты аутентификации...
Route::post('/login', 'Auth\LoginController@login');
Route::get('/logout', 'Auth\LoginController@logout');


Route::get('/', function () {
    return redirect('/school0');
});
Route::get('/home', function () {
    return redirect('/school0');
});


// Калькулятор
Route::get('/calc', 'CalcController@calcPage');

// добавление файла изображения
Route::get('/img_upload', 'Controller@imgUploadPage');
Route::post('/img_upload.php', 'Controller@imgUploadPOST');

// Главная страница школы
Route::get('/{schoolUri}', 'SchoolController@showMainPage');
// Страница редактирование html-содержимого на главной странице школы
Route::get('/{schoolUri}/edit_main_page', 'SchoolController@editMainPage');
// Метод-обработчик редактирования главной страницы школы
Route::post('/{schoolUri}/edit_main_page.php', 'SchoolController@editMainPagePOST');



// страница с каким-либо разделом (Например: 7 класс)
Route::get('/{schoolUri}/{sectionUri}', 'SectionController@showSectionPage');

//// страница с каким-нибудь уроком (Например: 7 класс/ урок 1)
//Route::get('/{sectionURL}/{lessonURL}', 'HomeController@showLessonPage');
//
//// страница с тестом (Например: 7-class/mekhanicheskoe-dvizhenie-tel/test-po-mekhanike)
//Route::get('/{sectionURL}/{lessonURL}/{testURL}', 'HomeController@showTestPage');
//Route::post('/{testURL}/verificate_test.php', 'PostController@verificateTest');



//// Тестовая страница
//Route::get('/test', 'HomeController@testPage');
//Route::get('/test2', 'HomeController@testPage2');
//
//
//// добавление комментария
//Route::post('/add_comment', 'PostController@addComment');
//
//// редактирование личных данных ученика
//Route::post('/change_user_info.php', 'PostController@changeUserInfoPOST');
//
//// личный кабинет
//Route::get('/cabinet', 'HomeController@cabinetPage');
//Route::post('/edit_users.php', 'PostController@editUsersPOST');
//// удаление результата теста
//Route::post('/delete_test_result.php', 'PostController@deleteTestResultPOST');
//
//// добавление файла изображения
//Route::get('/add_img', 'HomeController@addImgPage');
//Route::post('/add_img.php', 'PostController@addImgPOST');
//
//// добавление урока
//Route::get('/{sectionURL}/add_lesson', 'HomeController@addLessonPage');
//Route::post('/{sectionURL}/add_lesson.php', 'PostController@addLessonPOST');
//// редактирование урока
//Route::get('/{sectionURL}/{lessonURL}/edit_lesson', 'HomeController@editLessonPage');
//Route::post('/{sectionURL}/edit_lesson.php', 'PostController@editLessonPOST');
//// удаление урока
//Route::get('/{sectionURL}/{lessonURL}/delete_lesson', 'HomeController@deleteLesson');
//// восстановление урока
//Route::get('/{sectionURL}/{lessonURL}/restore_lesson', 'HomeController@restoreLesson');
//// пометить урок удалённым
//Route::get('/{sectionURL}/{lessonURL}/mark_as_deleted', 'HomeController@markAsDeletedLesson');
//
//
//// добавление теста
//Route::get('/{sectionURL}/{lessonURL}/add_test', 'HomeController@addTest');
//Route::post('/{lessonURL}/add_test.php', 'PostController@addTestPOST');
//// редактирвоание теста
//Route::get('/{sectionURL}/{lessonURL}/{testURL}/edit_test', 'HomeController@editTest');
//Route::post('/{testURL}/edit_test.php', 'PostController@editTestPOST');
//// удаление теста из базы
//Route::get('/{sectionURL}/{lessonURL}/{testURL}/delete_test', 'HomeController@deleteTest');
//// восстановление теста
//Route::get('/{sectionURL}/{lessonURL}/{testURL}/restore_test', 'HomeController@restoreTest');
//// пометить тест, как удалённый
//Route::get('/{sectionURL}/{lessonURL}/{testURL}/mark_as_deleted', 'HomeController@markAsDeletedTest');
//
//

//// обновление аватарки
//Route::post('/reload_avatar.php', 'PostController@reloadAvatar');
