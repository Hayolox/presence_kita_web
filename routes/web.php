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
    Route::get('/ManageSubject-detail-lecturer/{id}', [ManageSubjectsController::class, 'dataLecturer'])->name('ManageSubject.lecturer');
    Route::get('/ManageSubject-detail-student/{id}', [ManageSubjectsController::class, 'dataStudent'])->name('ManageSubject.student');
    Route::post('/ManageSubject-detail-lecturer-store/{id}', [ManageSubjectsController::class, 'dataLecturerStore'])->name('ManageSubject.lecturer-store');
    Route::post('/ManageSubject-import-student', [ManageSubjectsController::class, 'import'])->name('ManageSubject.import');
    Route::delete('/ManageSubject-detail-lecturer-destroy/{id}', [ManageSubjectsController::class, 'dataLecturerDestroy'])->name('ManageSubject.lecturerDestroy');
    Route::delete('/ManageSubject-detail-student-destroy/{id}', [ManageSubjectsController::class, 'dataStudentDestroy'])->name('ManageSubject.studentDestroy');




});

