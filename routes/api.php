<?php

use Illuminate\Http\Request;
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


//Route::get('/users', [\App\Http\Controllers\Admin\DashboardController::class, 'index']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/users', [\App\Http\Controllers\User\DashboardController::class, 'index']);
});

Route::group([/*'middleware' => ['auth:sanctum',  'admin' ]*/], function () {
    Route::get('/admin', \App\Http\Controllers\Admin\DashboardController::class);

    Route::get('/admin/tournament', [\App\Http\Controllers\Admin\TournamentController::class, 'index']);
    Route::post('/admin/tournament/store', [\App\Http\Controllers\Admin\TournamentController::class, 'store']);
    Route::get('/admin/tournament/{id}', [\App\Http\Controllers\Admin\TournamentController::class, 'edit']);
    Route::patch('/admin/tournament/{id}/update', [\App\Http\Controllers\Admin\TournamentController::class, 'update']);

    Route::post('/admin/stage/store', [\App\Http\Controllers\Admin\StageController::class, 'store']);
    Route::get('/admin/stage/{id}', [\App\Http\Controllers\Admin\StageController::class, 'tournament']);
    Route::get('/admin/stage/{id}/edit', [\App\Http\Controllers\Admin\StageController::class, 'edit']);
    Route::patch('/admin/stage/{id}/update', [\App\Http\Controllers\Admin\StageController::class, 'update']);

    Route::post('/admin/stage/{id}/start', [\App\Http\Controllers\Admin\StageController::class, 'startStage']);
    Route::post('/admin/stage/{id}/finish-group', [\App\Http\Controllers\Admin\StageController::class, 'finishGroup']);
    Route::post('/admin/stage/{id}/finish-fleet', [\App\Http\Controllers\Admin\StageController::class, 'finishFleet']);

    Route::get('/admin/stage/{stageId}/races', [\App\Http\Controllers\Admin\RaceController::class, 'getStageRaces']);
    Route::get('/admin/stage/{id}/meta', [\App\Http\Controllers\Admin\StageController::class, 'getStageStatusGroup']);

    Route::post('/admin/race/{id}/results', [\App\Http\Controllers\Admin\RaceController::class, 'storeResults']);
    Route::get('/admin/stage/{stageId}/races/{status}/group/{groupId}', [\App\Http\Controllers\Admin\RaceController::class, 'getStageRaces']);
    Route::get('/admin/race/{id}', [\App\Http\Controllers\Admin\RaceController::class, 'getRacePlace']);
    Route::get('/admin/race/{id}/users', [\App\Http\Controllers\Admin\RaceController::class, 'getRaceUsers']);


    Route::post('/admin/race/create', [\App\Http\Controllers\Admin\RaceController::class, 'createRace']);
    Route::post('/admin/race/{id}/remove', [\App\Http\Controllers\Admin\RaceController::class, 'destroy']);


    Route::get('/admin/stage/{stageId}/{groupId}/{status}/total', [\App\Http\Controllers\Admin\StageController::class, 'getTotal']);
    Route::get('/admin/stage/{stageId}/{groupId}/{status}/total-detail', [\App\Http\Controllers\Admin\StageController::class, 'getTotalDetail']);

});


Route::group([], function() {
    Route::get('/stage/{id}', [\App\Http\Controllers\Guest\StageController::class, 'getResult']);
    Route::get('/universities', \App\Http\Controllers\Guest\RegistrationController::class);
});

