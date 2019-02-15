<?php

Route::localizedGroup(function () {
    Route::prefix(config('cms.uri'))->as(config('cms.admin_prefix'))->group(function () {
        Route::resource('DummySlug', 'Admin\IndexController');
        /*Route::delete('DummySlug/delete-upload/{id}/{field}', 'Admin\IndexController@deleteUpload')
            ->name('DummySlug.delete-upload');*/
    });
});
