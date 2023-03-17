<?php

use App\Http\Controllers\API\AuthContorller;
use App\Http\Controllers\API\HomeApiController;
use App\Http\Controllers\API\PresenceApiController;
use App\Http\Controllers\API\SessionApiController;
use App\Http\Controllers\API\SUSController;
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
Route::post('/login-proses-register', [AuthContorller::class, 'register']);
Route::get('/logout-proses-student', [AuthContorller::class, 'logout']);



Route::middleware('auth:sanctum')->group(function () {
    Route::get('/home', [HomeApiController::class, 'index']);
    Route::get('/session-subject', [SessionApiController::class, 'index']);
    Route::get('/session-detail-do-not-attend', [SessionApiController::class, 'doNotAttend']);
    Route::post('/create-session', [SessionApiController::class, 'store']);
    Route::get('/session-get-lecturer-By-Subject', [SessionApiController::class, 'getLecturerBySubject']);
    Route::put('/update-session', [SessionApiController::class, 'update']);
    Route::post('/presence-present', [PresenceApiController::class, 'present']);
    Route::post('/presence-izin', [PresenceApiController::class, 'izin']);


    Route::get('/sus-Question', [SUSController::class, 'getQuestion']);
    Route::post('/sus-Answer', [SUSController::class, 'postAnswer']);

    Route::post('/change-password', [AuthContorller::class, 'changePassword']);
});
