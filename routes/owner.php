<?php

use App\Http\Controllers\Owner\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Owner\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Owner\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Owner\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Owner\Auth\NewPasswordController;
use App\Http\Controllers\Owner\Auth\PasswordResetLinkController;
use App\Http\Controllers\Owner\Auth\RegisteredUserController;
use App\Http\Controllers\Owner\Auth\VerifyEmailController;
use App\Http\Controllers\Owner\OwnersController;
use App\Http\Controllers\Owner\OwnerCsvController;
use App\Http\Controllers\Owner\OwnerSendMailController;
use App\Http\Controllers\Owner\UsersController;
use App\Http\Controllers\Owner\UsersExpiredController;
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
//     return view('owner.welcome');
// });

Route::get('/dashboard', function () {
    return view('owner.dashboard');
})->middleware(['auth:owners'])->name('dashboard');

// Ownerresource
Route::resource('owners', OwnersController::class)
->middleware('auth:owners');

// Userresource
Route::resource('users', UsersController::class)
->middleware('auth:owners');



// owner_expired
Route::prefix('expired-owner')->middleware('auth:owners')->group(function () {
    Route::get('index', [OwnersController::class, 'expiredOwnerIndex'])->name('expired-owners.index');
    Route::post('restore/{owner}', [OwnersController::class, 'expiredOwnerRestore'])->name('expired-owners.restore');
    Route::post('destroy/{owner}', [OwnersController::class, 'expiredOwnerDestroy'])->name('expired-owners.destroy');
});

//user_expired
Route::prefix('expired-user')->middleware('auth:owners')->group(function (){
    Route::get('index', [UsersExpiredController::class, 'expiredUserIndex'])->name('expired-users.index');
    Route::post('restore/{user}', [UsersExpiredController::class, 'expiredUserRestore'])->name('expired-users.restore');
    Route::post('destroy/{user}', [UsersExpiredController::class, 'expiredUserDestroy'])->name('expired-users.destroy');
});


// owner_csv
Route::get('csvdownload', [OwnerCsvController::class, 'ownerCsvDownload'])->middleware('auth:owners')->name('owner_csv_download');
Route::post('csvupload', [OwnerCsvController::class, 'ownerCsvUpload'])->middleware('auth:owners')->name('owner_csv_upload');

//user_csv

//owner_mail
Route::prefix('mail-owner')->middleware('auth:owners')->group(function () {
    Route::get('create/{id}', [OwnerSendMailController::class, 'create'])->name('owner_create_mail');
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

Route::middleware('auth:owners')->group(function () {
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

