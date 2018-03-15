<?php

/**
 * Admin Route/s
 */
Route::group([
    'as' => 'voyager.forms.',
    'prefix' => 'admin',
    'middleware' => ['web', 'admin.user']
], function () {
    Route::resource('/forms', '\Pvtl\VoyagerForms\Http\Controllers\FormController');
    Route::resource('/enquiries', '\Pvtl\VoyagerForms\Http\Controllers\EnquiryController');
});
