<?php

/*
 * Blogs Management
 */
Route::group(['namespace' => 'Blogs'], function () {
    Route::resource('blogs', 'BlogsController', ['except' => ['create', 'edit']]);

    //For DataTables
    //Route::post('blogs', 'BlogsController@search');
});
