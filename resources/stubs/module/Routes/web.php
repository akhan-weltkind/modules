<?php

Route::localizedGroup(function () {
    Route::prefix(config('cms.uri'))
        ->as(config('cms.uri-alias'))
        ->group(function (){
            Route::resource('DummySlug', 'Admin\IndexController');
            //Route::delete('DummySlug/delete-upload/{id}/{field}', 'Admin\IndexController@deleteUpload')->name('DummySlug.delete-upload');
        });
});