<?php
/**
 * Standard
 *
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    
    Route::group( ['namespace' => 'Standard'], function () {
        Route::resource('standards', 'StandardsController');
        //For Datatable
        Route::post('standards/get', 'StandardsTableController')->name('standards.get');
    });
    
});