<?php

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
// Route::group(
//     [
//         'prefix' => getlocale(),
//         'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
//     ],
//     function()
//     {
//         Route::group(['middleware' => ['loginCheck']], function () {
//         // Route::get('/', 'UserController@index')->name('user-index');
//         Route::get('/', function () {
//             return view('welcome');
//         });
//         });
//     });

Route::get('/test',function(){
    if (in_array('image/gif', \Intervention\Image\ImageManagerStatic::getSupportedFormats())) {
        echo 'GIF is supported!';
    } else {
        echo 'GIF is not supported!';
    }
});
