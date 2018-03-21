<?php

/**
 * Admin Route/s
 */
Route::group([
    'prefix' => 'admin',
    'middleware' => ['web', 'admin.user'],
    ['namespace' => 'Pvtl\VoyagerForms\Http\Controllers']
], function ($test) {
    Route::resource('forms', 'FormController');
    Route::resource('inputs', 'FormInputController');
    Route::resource('enquiries', 'EnquiryController');
});
