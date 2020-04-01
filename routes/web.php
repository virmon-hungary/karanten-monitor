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

Route::group(['middleware' => 'default-guard-setter:portal'], function () {

    Route::get('/', function () {
        return view('welcome');
    });

    Auth::routes(['verify' => true]);
    Route::group(['middleware' => ['auth']], function () {
        Route::get('/home', 'HomeController@index')->name('home');
        Route::get('/logout', [\App\Http\Controllers\Patient\Auth\LoginController::class, 'logout'])->name('logout');
        Route::get('/create/patient', [\App\Http\Controllers\PatientHandleController::class, 'showCreate'])->name('create.patient');
        Route::post('/create/patient', [\App\Http\Controllers\PatientHandleController::class, 'create'])->name('create.patient');
    });

    Route::group(['prefix' => 'patient', 'as' => 'patient.', 'middleware' => 'default-guard-setter:patient'], function () {

        Route::get('login', [\App\Http\Controllers\Patient\Auth\LoginController::class, 'showLoginForm'])->name('loginPatient');
        Route::post('login', [\App\Http\Controllers\Patient\Auth\LoginController::class, 'login'])->name('login');

//        Route::get('register', [\App\Http\Controllers\Patient\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
//        Route::post('register', [\App\Http\Controllers\Patient\Auth\RegisterController::class, 'register']);

        Route::get('password/reset', [\App\Http\Controllers\Patient\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
        Route::post('password/email', [\App\Http\Controllers\Patient\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
        Route::get('password/reset/{token}', [\App\Http\Controllers\Patient\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
        Route::post('password/reset', [\App\Http\Controllers\Patient\Auth\ResetPasswordController::class, 'reset'])->name('password.update');

        Route::get('password/confirm', [\App\Http\Controllers\Patient\Auth\ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
        Route::post('password/confirm', [\App\Http\Controllers\Patient\Auth\ConfirmPasswordController::class, 'confirm']);

//        Route::get('email/verify', [\App\Http\Controllers\Patient\Auth\VerificationController::class, 'show'])->name('verification.notice');
//        Route::get('email/verify/{id}/{hash}', [\App\Http\Controllers\Patient\Auth\VerificationController::class, 'verify'])->name('verification.verify');
//        Route::post('email/resend', [\App\Http\Controllers\Patient\Auth\VerificationController::class, 'resend'])->name('verification.resend');

        Route::group(['middleware' => 'auth.patient'], function () {
            Route::get('/', [\App\Http\Controllers\Patient\HomeController::class, 'index']);
            Route::get('/home', [\App\Http\Controllers\Patient\HomeController::class, 'index'])->name('home');
            Route::get('logout', [\App\Http\Controllers\Patient\Auth\LoginController::class, 'logout'])->name('logout');
        });
    });
});

