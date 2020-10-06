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

Route::apiResource('groups', 'App\Http\Controllers\Api\GroupApiController');
Route::apiResource('procreators', 'App\Http\Controllers\Api\ProcreatorApiController');
Route::apiResource('clients','App\Http\Controllers\Api\ClientApiController');
// START Schedule Routes
Route::get('schedule/{week_id}/{group_id}', ["App\Http\Controllers\Api\ScheduleApiController", "getSchedule"]);
Route::put('schedule', ["App\Http\Controllers\Api\ScheduleApiController", "updateSchedule"]);
Route::get('schedule/{id}', ["App\Http\Controllers\Api\ScheduleApiController", "show"]);
Route::get('weeks',  ["App\Http\Controllers\Api\ScheduleApiController", "getWeeks"]);
// START Schedule Routes