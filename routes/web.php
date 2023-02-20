<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ManageLecturerController;
use App\Http\Controllers\Admin\ManageStudentController;
use App\Http\Controllers\Admin\ManageSubjectsController;
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


    Route::resource('/ManageLecturer', ManageLecturerController::class);
    Route::resource('/ManageStudent', ManageStudentController::class);
    Route::post('/ManageStudent-import', [ManageStudentController::class, 'import'])->name('ManageStudent.import');

    Route::resource('/ManageSubject', ManageSubjectsController::class);




});

