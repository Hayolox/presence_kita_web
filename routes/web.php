<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ManageLecturerDataController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::prefix('Admin')->group(function(){
    Route::get('/Dashboard', [DashboardController::class, 'index'])->name('Dashboard');


    Route::get('/ManageLecturer', [ManageLecturerDataController::class, 'index'])->name('lecturer');
    Route::delete('/ManageLecturer-Delete/{id}', [ManageLecturerDataController::class, 'delete'])->name('lecturer-delete');
});

