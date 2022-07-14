<?php

use App\Http\Controllers\Admin\AdminsController;
use App\Http\Controllers\Admin\OwnersController;
use App\Http\Controllers\Admin\AdminCsvController;
use App\Http\Controllers\Admin\AdminSendMailController;
use App\Http\Controllers\Admin\AdminExpiredController;
use App\Http\Controllers\Admin\OwnerCsvController;
use App\Http\Controllers\Admin\OwnerSendMailController;
use App\Http\Controllers\Admin\OwnerExpiredController;
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


//AdminResource
Route::resource('admin', AdminsController::class)
->middleware('auth:admin');

//OwnersResource
Route::resource('owners', OwnersController::class)
    ->middleware('auth:admin');

//admin_expired
Route::prefix('expired-admin')->middleware('auth:admin')->group(function(){
    Route::get('index', [AdminExpiredController::class, 'expiredAdminIndex'])->name('expired-admin.index');
    Route::post('restore/{admin}', [AdminExpiredController::class, 'expiredAdminRestore'])->name('expired-admin.restore');
    Route::post('destroy/{admin}', [AdminExpiredController::class, 'expiredAdminDestroy'])->name('expired-admin.destroy');
});

// owner_expired
Route::prefix('expired-owners')->middleware('auth:admin')->group(function () {
    Route::get('index', [OwnerExpiredController::class, 'expiredOwnersIndex'])->name('expired-owners.index');
    Route::post('restore/{owner}', [OwnerExpiredController::class, 'expiredOwnersRestore'])->name('expired-owners.restore');
    Route::post('destroy/{owner}', [OwnerExpiredController::class, 'expiredOwnersDestroy'])->name('expired-owners.destroy');
});

//admin_csv
Route::prefix('scv-admin')->middleware('auth:admin')->group(function(){
    Route::get('download', [AdminCsvController::class,'adminCsvDownLoad'])->name('admin_csv_download');
    Route::post('upload', [AdminCsvController::class, 'adminCsvUpload'])->name('admin_csv_upload');
});

//owner_csv
Route::prefix('scv-owner')->middleware('auth:admin')->group(function(){
    Route::get('download', [OwnerCsvController::class, 'ownerCsvDownload'])->name('owner_csv_download');
    Route::post('upload', [OwnerCsvController::class, 'ownerCsvUpload'])->name('owner_csv_upload');
});

//admin_mail
Route::prefix('mail-admin')->middleware(('auth:admin'))->group(function(){
    Route::get('create/{id}', [AdminSendMailController::class, 'create'])->name('admin_create_mail');
    Route::post('confirm', [AdminSendMailController::class, 'confirm'])->name('admin_confirm_mail');
    Route::post('send', [AdminSendMailController::class, 'send'])->name('admin_send_mail');
});

//owner_mail
Route::prefix('mail-owner')->middleware(('auth:admin'))->group(function () {
    Route::get('create/{id}', [OwnerSendMailController::class, 'create'])->name('owner_create_mail');
    Route::post('confirm', [OwnerSendMailController::class, 'confirm'])->name('owner_confirm_mail');
    Route::post('send', [OwnerSendMailController::class, 'send'])->name('owner_send_mail');
});

require __DIR__.'/admin_auth.php';