<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// START groups Routes
Route::apiResource('groups', 'App\Http\Controllers\Api\GroupApiController');
// END procreators Routes

// START procreators Routes
Route::apiResource('procreators', 'App\Http\Controllers\Api\ProcreatorApiController');
// END procreators Routes

// START client Routes
Route::apiResource('clients', 'App\Http\Controllers\Api\ClientApiController');
// END client Routes

// START Schedule Routes
Route::get('schedule/{week_id}/{group_id}', ["App\Http\Controllers\Api\ScheduleApiController", "getSchedule"]);
Route::put('schedule', ["App\Http\Controllers\Api\ScheduleApiController", "updateSchedule"]);
Route::get('schedule/{id}', ["App\Http\Controllers\Api\ScheduleApiController", "show"]);
Route::get('weeks',  ["App\Http\Controllers\Api\ScheduleApiController", "getWeeks"]);
Route::get('get_time/{client_id}', ["App\Http\Controllers\Api\ScheduleApiController", "getTime"]);
// END Schedule Routes

// START ClientSchedule Routes
Route::get('client_schedule/{client_id}', ["App\Http\Controllers\Api\ClientScheduleApiController", "getSchedule"]);
Route::put('client_schedule', ["App\Http\Controllers\Api\ClientScheduleApiController", "updateSchedule"]);
// END ClientSchedule Routes

// START Record Routes
Route::apiResource('records', 'App\Http\Controllers\Api\RecordApiController');
// END Record Routes
