<?php

use Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['prefix' => 'patient'], function () {

    Route::get('login', [\App\Http\Controllers\AuthPatient\LoginController::class, 'showLoginForm'])->name('loginPatient');
    Route::post('login', [\App\Http\Controllers\AuthPatient\LoginController::class, 'login'])->name('login');

    Route::get('register', [\App\Http\Controllers\AuthPatient\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [\App\Http\Controllers\AuthPatient\RegisterController::class, 'register']);

    Route::get('password/reset', [\App\Http\Controllers\AuthPatient\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [\App\Http\Controllers\AuthPatient\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [\App\Http\Controllers\AuthPatient\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [\App\Http\Controllers\AuthPatient\ResetPasswordController::class, 'reset'])->name('password.update');

    Route::get('password/confirm', [\App\Http\Controllers\AuthPatient\ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
    Route::post('password/confirm', [\App\Http\Controllers\AuthPatient\ConfirmPasswordController::class, 'confirm']);

    Route::get('email/verify', [\App\Http\Controllers\AuthPatient\VerificationController::class, 'show'])->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', [\App\Http\Controllers\AuthPatient\VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('email/resend', [\App\Http\Controllers\AuthPatient\VerificationController::class, 'resend'])->name('verification.resend');

    Route::group(['middleware' => ['auth:patient']], function () {
        Route::get('logout', [\App\Http\Controllers\AuthPatient\LoginController::class,'logout'])->name('logout');
    });
});


Route::get('/home', 'HomeController@index')->name('home');
