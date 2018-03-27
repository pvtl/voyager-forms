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
