<?php
/**
 * Student
 *
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    
    Route::group( ['namespace' => 'Student'], function () {
        Route::resource('students', 'StudentsController');
        //For Datatable
        Route::post('students/get', 'StudentsTableController')->name('students.get');
    });
    
});