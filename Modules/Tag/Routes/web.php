<?php

Route::group(
    [
        'prefix' => getlocale(),
        'middleware' => ['localeSessionRedirect', 'localeViewPath' , 'localizationRedirect']
    ],
    function () {

    Route::prefix('tag')->group(function() {
        Route::group(['middleware' => ['loginCheck']], function () {
            Route::get('/', 'TagController@index')->name('tags');
        });
    });
});