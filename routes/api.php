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

Route::group(['middleware' => ['auth:sanctum', 'admin']], function () {
    Route::get('/admin', \App\Http\Controllers\Admin\DashboardController::class);
    Route::post('/admin/tournament/store', [\App\Http\Controllers\Admin\TournamentController::class, 'store']);
    Route::get('/admin/tournament/{id}', [\App\Http\Controllers\Admin\TournamentController::class, 'edit']);
    Route::patch('/admin/tournament/{id}/update', [\App\Http\Controllers\Admin\TournamentController::class, 'update']);
});

