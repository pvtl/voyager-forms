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
    // Route::post('layout/{id}', ['uses' => "FormController@changeLayout", 'as' => 'layout']);
});
