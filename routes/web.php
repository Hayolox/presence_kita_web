<?php

use App\Http\Controllers\Admin\ChangePasswordController;
use App\Http\Controllers\Admin\CheckLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ManageLecturerController;
use App\Http\Controllers\Admin\ManageStudentController;
use App\Http\Controllers\Admin\ManageSubjectsController;
use App\Http\Controllers\Admin\ManageSUSController;
use App\Http\Controllers\Admin\ManageSystemController;
use App\Http\Controllers\Admin\PresenceController;
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
    Route::post('/ManageStudent-import-student', [ManageStudentController::class, 'import'])->name('ManageStudent.import');
    Route::get('/ManageStudent-download-import-student', [ManageStudentController::class, 'downloadTemplate'])->name('ManageStudent.template.import.student');


    Route::get('/Check-Login', [CheckLoginController::class, 'index'])->name('check.login');
    Route::delete('/check-login/{id}', [CheckLoginController::class, 'destroy'])->name('check.login.destroy');

    Route::resource('/ManageSubject', ManageSubjectsController::class);
    Route::get('/ManageSubject-classrooms/{subject_course_code}', [ManageSubjectsController::class, 'classroom'])->name('ManageSubject.classroom');
    Route::get('/ManageSubject-classrooms/create/{subject_course_code}', [ManageSubjectsController::class, 'createClassroom'])->name('ManageSubject.create.classroom');
    Route::get('/ManageSubject-detail-lecturer/{classrooms_id}', [ManageSubjectsController::class, 'dataLecturer'])->name('ManageSubject.lecturer');
    Route::get('/ManageSubject-detail-student/{classrooms_id}', [ManageSubjectsController::class, 'dataStudent'])->name('ManageSubject.student');
    Route::get('/ManageSubject-create-student/{classrooms_id}', [ManageSubjectsController::class, 'dataStudentCreate'])->name('ManageSubject.dataStudentCreate');
    Route::get('/ManageSubject-create-student/download/template', [ManageSubjectsController::class, 'downloadTemplate'])->name('ManageSubject.dataStudentDownloadTemplate');
    Route::post('/ManageSubject-classrooms-store/{classrooms_id}', [ManageSubjectsController::class, 'storeClassromm'])->name('ManageSubject.store.classroom');
    Route::post('/ManageSubject-store-student/{classrooms_id}', [ManageSubjectsController::class, 'dataStudentStore'])->name('ManageSubject.dataStudentStore');
    Route::post('/ManageSubject-detail-lecturer-store/{classrooms_id}', [ManageSubjectsController::class, 'dataLecturerStore'])->name('ManageSubject.lecturer-store');
    Route::post('/ManageSubject-import-student/{classrooms_id}', [ManageSubjectsController::class, 'import'])->name('ManageSubject.import');
    Route::delete('/ManageSubject-detail-lecturer-destroy/{classrooms_id}', [ManageSubjectsController::class, 'dataLecturerDestroy'])->name('ManageSubject.lecturerDestroy');
    Route::delete('/ManageSubject-detail-student-destroy/{classrooms_id}', [ManageSubjectsController::class, 'dataStudentDestroy'])->name('ManageSubject.studentDestroy');
    Route::delete('/ManageSubject-classrooms-destroy/{id}', [ManageSubjectsController::class, 'destroyClassroom'])->name('ManageSubject.destroy.classroom');



    Route::get('/Change-password-admin', [ChangePasswordController::class, 'index'])->name('change.password.admin');
    Route::post('/Change-password-admin-update', [ChangePasswordController::class, 'update'])->name('change.password.admin.update');


    Route::get('/Manage-SUS', [ManageSUSController::class, 'index'])->name('ManageSUS');
    Route::get('/Manage-SUS-detail', [ManageSUSController::class, 'sus'])->name('ManageSUS.detail');
    Route::put('/Manage-SUS-update', [ManageSUSController::class, 'update'])->name('ManageSUS.update');

    Route::get('/Manage-presence', [PresenceController::class, 'index'])->name('ManagePresence');
    Route::get('/Manage-presence/classrooms/{subject_course_code}', [PresenceController::class, 'classroom'])->name('ManagePresence.classrooms');
    Route::get('/Manage-presence-session/{classrooms_id}', [PresenceController::class, 'session'])->name('ManagePresence.session');
    Route::get('/Manage-presence/create/{classrooms_id}', [PresenceController::class, 'createSession'])->name('ManagePresence.session.create');
    Route::post('/Manage-presence/create/{classrooms_id}', [PresenceController::class, 'storeSession'])->name('ManagePresence.session.store');
    Route::get('/Manage-presence/edit/{id}/{classrooms_id}', [PresenceController::class, 'editSession'])->name('ManagePresence.session.edit');
    Route::get('/Manage-presence/izin/{classrooms_id}', [PresenceController::class, 'izin'])->name('ManagePresence.session.izin');
    Route::put('/Manage-presence/update/{id}/{classrooms_id}', [PresenceController::class, 'updateSession'])->name('ManagePresence.session.update');
    Route::get('/Manage-presence/{id}/{classrooms_id}', [PresenceController::class, 'presence'])->name('ManagePresence.presence');
    Route::get('/Manage-presence/add/to/presence/{id}/{classrooms_id}', [PresenceController::class, 'addStudentToPresence'])->name('ManagePresence.presence.add.student');
    Route::post('/Manage-presence/store/to/presence/{id}/{classrooms_id}', [PresenceController::class, 'storeAddStudentToPresence'])->name('ManagePresence.presence.store.student');
    Route::get('/Manage-presence/Qr-Code/{id}/{QrCode}', [PresenceController::class, 'qRCode'])->name('ManagePresence.QrCode');

});

