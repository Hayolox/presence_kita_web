<?php

use App\Http\Controllers\API\AuthContorller;
use App\Http\Controllers\API\HomeApiController;
use App\Http\Controllers\API\SessionApiController;
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

Route::post('/login-proses-student', [AuthContorller::class, 'login']);
Route::get('/logout-proses-student', [AuthContorller::class, 'logout']);



Route::middleware('auth:sanctum')->group(function () {
    Route::get('/home', [HomeApiController::class, 'index']);
    Route::get('/session-subject', [SessionApiController::class, 'index']);
    Route::get('/session-detail-do-not-attend', [SessionApiController::class, 'doNotAttend']);
    Route::post('/create-session', [SessionApiController::class, 'store']);
});
