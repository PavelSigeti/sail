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

    Route::get('/settings', [\App\Http\Controllers\User\DashboardController::class, 'settings']);
    Route::post('/team/store', [\App\Http\Controllers\User\TeamController::class, 'store']);
    Route::get('/team/edit', [\App\Http\Controllers\User\TeamController::class, 'edit']);
    Route::delete('/team/delete', [\App\Http\Controllers\User\TeamController::class, 'destroy']);

    Route::post('/user/search', [\App\Http\Controllers\User\UserController::class, 'search']);
    Route::post('/user/remove-teammate', [\App\Http\Controllers\User\UserController::class, 'removeTeammate']);
    Route::post('/team-invite', [\App\Http\Controllers\User\TeamInviteController::class, 'store']);
    Route::delete('/team-invite/{id}/delete', [\App\Http\Controllers\User\TeamInviteController::class, 'destroy']);
    Route::post('/team-invite/{id}/accept', [\App\Http\Controllers\User\TeamInviteController::class, 'accept']);
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
    Route::post('/admin/stage/{id}/finish', [\App\Http\Controllers\Admin\StageController::class, 'finish']);
    Route::post('/admin/stage/{id}/finish-group', [\App\Http\Controllers\Admin\StageController::class, 'finishGroup']);

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

    Route::get('/admin/universities', [\App\Http\Controllers\Admin\UniversityController::class, 'index']);
    Route::post('/admin/universities/store', [\App\Http\Controllers\Admin\UniversityController::class, 'store']);
    Route::delete('/admin/universities/{id}/delete', [\App\Http\Controllers\Admin\UniversityController::class, 'destroy']);

    Route::get('/admin/pages', [\App\Http\Controllers\Admin\PageController::class, 'index']);
    Route::post('/admin/page/store', [\App\Http\Controllers\Admin\PageController::class, 'store']);
    Route::get('/admin/page/{id}', [\App\Http\Controllers\Admin\PageController::class, 'edit']);
    Route::patch('/admin/page/{id}/update', [\App\Http\Controllers\Admin\PageController::class, 'update']);
});


Route::group([], function() {
    Route::get('/stage/{id}', [\App\Http\Controllers\Guest\StageController::class, 'getResult']);
    Route::get('/universities', \App\Http\Controllers\Guest\RegistrationController::class);
});

