<?php

/**
 * Admin Route/s
 */
Route::group([
    'as' => 'voyager.forms.',
    'prefix' => 'admin/forms/',
    'middleware' => ['web', 'admin.user'],
    'namespace' => '\Pvtl\VoyagerForms\Http\Controllers'
], function () {
    Route::post('order', ['uses' => "InputController@order", 'as' => 'order']);
});

/**
 * Front-end Route/s
 */
Route::group([
    'as' => 'voyager.enquiries.',
    'middleware' => ['web'],
    'namespace' => '\Pvtl\VoyagerForms\Http\Controllers'
], function () {
    Route::post('voyager-forms-submit-enquiry/{id}', ['uses' => "EnquiryController@submit", 'as' => 'submit']);
});
