<?php

use Illuminate\Support\Facades\Route;



$credentials = [
    'namespace' => 'App\Http\Controllers\Api\MobileApplications',
];


Route::group($credentials, function () {
    /* Parent application routes start */
    Route::post('/getKgContact', 'ParentApplicationController@getKgContact');
    Route::post('/getActivitiesInfo', 'ParentApplicationController@getActivitiesInfo');
    Route::post('/getKgImages', 'ParentApplicationController@getKgImages');
    Route::post('/abcenseRecording', 'ParentApplicationController@abcenseRecording');
    /* Parent application routes end */
});
