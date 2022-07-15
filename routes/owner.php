<?php


use App\Http\Controllers\Owner\OwnersController;
use App\Http\Controllers\Owner\OwnerCsvController;
use App\Http\Controllers\Owner\OwnerSendMailController;
use App\Http\Controllers\Owner\OwnersExpiredController;
use App\Http\Controllers\Owner\UsersController;
use App\Http\Controllers\Owner\UsersExpiredController;
use App\Http\Controllers\Owner\UserCsvController;
use App\Http\Controllers\Owner\UserSendMailController;
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

// Ownerresource
Route::resource('owners', OwnersController::class)
->middleware('auth:owners');

// Userresource
Route::resource('users', UsersController::class)
->middleware('auth:owners');

// owner_expired
Route::prefix('expired-owner')->middleware('auth:owners')->group(function () {
    Route::get('index', [OwnersExpiredController::class, 'expiredOwnerIndex'])->name('expired-owners.index');
    Route::post('restore/{owner}', [OwnersExpiredController::class, 'expiredOwnerRestore'])->name('expired-owners.restore');
    Route::post('destroy/{owner}', [OwnersExpiredController::class, 'expiredOwnerDestroy'])->name('expired-owners.destroy');
});

//user_expired
Route::prefix('expired-user')->middleware('auth:owners')->group(function (){
    Route::get('index', [UsersExpiredController::class, 'expiredUserIndex'])->name('expired-users.index');
    Route::post('restore/{user}', [UsersExpiredController::class, 'expiredUserRestore'])->name('expired-users.restore');
    Route::post('destroy/{user}', [UsersExpiredController::class, 'expiredUserDestroy'])->name('expired-users.destroy');
});

// owner_csv
Route::prefix('csv-owner')->middleware('auth:owners')->group(function(){
    Route::get('download', [OwnerCsvController::class, 'ownerCsvDownload'])->name('owner_csv_download');
    Route::post('upload', [OwnerCsvController::class, 'ownerCsvUpload'])->name('owner_csv_upload');
});

//user_csv
Route::prefix('csv-user')->middleware('auth:owners')->group(function(){
    Route::get('download', [UserCsvController::class, 'userCsvDownload'])->name('user_csv_download');
    Route::post('upload', [UserCsvController::class, 'userCsvUpload'])->name('user_csv_upload');
});

//owner_mail
Route::prefix('mail-owner')->middleware('auth:owners')->group(function () {
    Route::get('create/{id}', [OwnerSendMailController::class, 'create'])->name('owner_create_mail');
    Route::post('confirm',[OwnerSendMailController::class, 'confirm'])->name('owner_confirm_mail');
    Route::post('send', [OwnerSendMailController::class, 'send'])->name('owner_send_mail');
});

// user_mail
Route::prefix('mail-user')->middleware('auth:owners')->group(function(){
    Route::get('create/{id}', [UserSendMailController::class, 'create'])->name('user_create_mail');
    Route::post('confirm', [UserSendMailController::class, 'confirm'])->name('user_confirm_mail');
    Route::post('send', [UserSendMailController::class, 'send'])->name('user_send_mail');
});

require __DIR__.'/owner_auth.php';