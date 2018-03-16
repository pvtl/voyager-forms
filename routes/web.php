<?php

/**
 * Admin Route/s
 */
Route::group([
    'prefix' => 'admin',
    'middleware' => ['web', 'admin.user'],
    ['namespace' => 'Pvtl\VoyagerForms\Http\Controllers']
], function () {
    Route::resource('forms', 'FormController');
    Route::resource('enquiries', 'EnquiryController');
});
