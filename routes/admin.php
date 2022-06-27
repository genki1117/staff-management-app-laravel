<?php

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Admin\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController;
use App\Http\Controllers\Admin\AdminsController;
use App\Http\Controllers\Admin\OwnersController;
use App\Http\Controllers\Admin\AdminCsvController;
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

// Route::get('/', function () {
//     return view('admin.welcome');
// });

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth:admin'])->name('dashboard');

//AdminContent
Route::resource('admin', AdminsController::class)
->middleware('auth:admin');

Route::prefix('expired-admin')->middleware('auth:admin')->group(function(){
    Route::get('index', [AdminsController::class, 'expiredAdminIndex'])->name('expired-admin.index');
    Route::post('restore/{admin}', [AdminsController::class, 'expiredAdminRestore'])->name('expired-admin.restore');
    Route::post('destroy/{admin}', [AdminsController::class, 'expiredAdminDestroy'])->name('expired-admin.destroy');
});

Route::get('csvdownload', [AdminCsvController::class, 'csvdownload'])->middleware('auth:admin')->name('csvDownLoad');

Route::post('csvupload', [AdminCsvController::class, 'csvupload'])->middleware('auth:admin')->name('admin_csv_upload');


//ownersContent
Route::resource('owners', OwnersController::class)
->middleware('auth:admin');

Route::prefix('expired-owners')->middleware('auth:admin')->group(function(){
    Route::get('index', [OwnersController::class, 'expiredOwnersIndex'])->name('expired-owners.index');
    Route::post('restore/{owner}', [OwnersController::class, 'expiredOwnersRestore'])->name('expired-owners.restore');
    Route::post('destroy/{owner}', [OwnersController::class, 'expiredOwnersDestroy'])->name('expired-owners.destroy');
});











Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.update');
});

Route::middleware('auth:admin')->group(function () {
    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
