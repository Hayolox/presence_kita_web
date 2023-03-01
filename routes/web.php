<?php

use App\Http\Controllers\Admin\ChangePasswordController;
use App\Http\Controllers\Admin\CheckLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ManageLecturerController;
use App\Http\Controllers\Admin\ManageStudentController;
use App\Http\Controllers\Admin\ManageSubjectsController;
use App\Http\Controllers\Admin\ManageSUSController;
use App\Http\Controllers\Admin\ManageSystemController;
use App\Http\Controllers\LoginController;
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
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login-proses', [LoginController::class, 'login'])->name('login.proses');
Route::get('/login-logout', [LoginController::class, 'logout'])->name('login.logout');


Route::prefix('Admin')->middleware('auth')->group(function(){
    Route::get('/Dashboard', [DashboardController::class, 'index'])->name('Dashboard');


    Route::resource('/ManageLecturer', ManageLecturerController::class);
    Route::resource('/ManageStudent', ManageStudentController::class);
    Route::resource('/ManageSystem', ManageSystemController::class);
    Route::post('/ManageStudent-import', [ManageStudentController::class, 'import'])->name('ManageStudent.import');

    Route::get('/Check-Login', [CheckLoginController::class, 'index'])->name('check.login');
    Route::delete('/check-login/{id}', [CheckLoginController::class, 'destroy'])->name('check.login.destroy');

    Route::resource('/ManageSubject', ManageSubjectsController::class);
    Route::get('/ManageSubject-detail-lecturer/{id}', [ManageSubjectsController::class, 'dataLecturer'])->name('ManageSubject.lecturer');
    Route::get('/ManageSubject-detail-student/{id}', [ManageSubjectsController::class, 'dataStudent'])->name('ManageSubject.student');
    Route::post('/ManageSubject-detail-lecturer-store/{id}', [ManageSubjectsController::class, 'dataLecturerStore'])->name('ManageSubject.lecturer-store');
    Route::post('/ManageSubject-import-student', [ManageSubjectsController::class, 'import'])->name('ManageSubject.import');
    Route::delete('/ManageSubject-detail-lecturer-destroy/{id}', [ManageSubjectsController::class, 'dataLecturerDestroy'])->name('ManageSubject.lecturerDestroy');
    Route::delete('/ManageSubject-detail-student-destroy/{id}', [ManageSubjectsController::class, 'dataStudentDestroy'])->name('ManageSubject.studentDestroy');



    Route::get('/Change-password-admin', [ChangePasswordController::class, 'index'])->name('change.password.admin');
    Route::post('/Change-password-admin-update', [ChangePasswordController::class, 'update'])->name('change.password.admin.update');


    Route::get('/Manage-SUS', [ManageSUSController::class, 'index'])->name('ManageSUS');
    Route::get('/Manage-SUS-Detail', [ManageSUSController::class, 'sus'])->name('ManageSUS.detail');

});

