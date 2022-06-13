<?php

use Illuminate\Support\Facades\Route;



$credentials = [
    'namespace' => 'App\Http\Controllers\Api\MobileApplications',
];


Route::group($credentials, function () {
    /* Parent application routes start */
    Route::post('/getChildren', 'ParentApplicationController@getChildren');
    Route::post('/getChildInfo/{child_id}', 'ParentApplicationController@getChildInfo');
    Route::post('/getEvaluations/{child_id}', 'ParentApplicationController@getEvaluations');
    Route::post('/getSubjectEvaluations/{child_id}', 'ParentApplicationController@getSubjectEvaluations');
    Route::post('/getTeacher/{child_id}', 'ParentApplicationController@getTeacher');
    Route::post('/getBusSuperVisor/{child_id}', 'ParentApplicationController@getBusSuperVisor');
    Route::post('/getKgContact', 'ParentApplicationController@getKgContact');
    Route::post('/getActivitiesInfo', 'ParentApplicationController@getActivitiesInfo');
    Route::post('/getKgImages', 'ParentApplicationController@getKgImages');
    Route::post('/abcenseRecording', 'ParentApplicationController@abcenseRecording');
    /* Parent application routes end */

    /* Teacher application routes end */
    Route::post('/getClassChildren', 'TeacherApplicationController@getClassChildren');
    Route::post('/childAbsence', 'TeacherApplicationController@childAbsence');
    Route::post('/setChildEval', 'TeacherApplicationController@setChildEval');
    Route::post('/getSeasonSubjects/{child_id}', 'TeacherApplicationController@getSeasonSubjects');
    Route::post('/setSubjectChildEval/{child_id}', 'TeacherApplicationController@setSubjectChildEval');
    /* Teacher application routes end */

    /* Bus Supervisor application routes end */
    Route::post('/getBusChildren', 'BusSupervisorApplicationController@getBusChildren');
    Route::post('/getBusItinerary', 'BusSupervisorApplicationController@getBusItinerary');
    Route::post('/getParentPhoneNumbers/{child_id}', 'BusSupervisorApplicationController@getParentPhoneNumbers');
    /* Bus Supervisor application routes end */
});
