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

Route::group(['prefix' => 'patient', 'as' => 'patient.'], function () {

    Route::get('login', [\App\Http\Controllers\Patient\Auth\LoginController::class, 'showLoginForm'])->name('loginPatient');
    Route::post('login', [\App\Http\Controllers\Patient\Auth\LoginController::class, 'login'])->name('login');

    Route::get('register', [\App\Http\Controllers\Patient\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [\App\Http\Controllers\Patient\Auth\RegisterController::class, 'register']);

    Route::get('password/reset', [\App\Http\Controllers\Patient\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [\App\Http\Controllers\Patient\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [\App\Http\Controllers\Patient\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [\App\Http\Controllers\Patient\Auth\ResetPasswordController::class, 'reset'])->name('password.update');

    Route::get('password/confirm', [\App\Http\Controllers\Patient\Auth\ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
    Route::post('password/confirm', [\App\Http\Controllers\Patient\Auth\ConfirmPasswordController::class, 'confirm']);

    Route::get('email/verify', [\App\Http\Controllers\Patient\Auth\VerificationController::class, 'show'])->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', [\App\Http\Controllers\Patient\Auth\VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('email/resend', [\App\Http\Controllers\Patient\Auth\VerificationController::class, 'resend'])->name('verification.resend');

    Route::group(['middleware' => ['auth:patient']], function () {
        Route::get('logout', [\App\Http\Controllers\Patient\Auth\LoginController::class,'logout'])->name('logout');
    });
});


Route::get('/home', 'HomeController@index')->name('home');

Route::post('/report', function () {
    dd(request()->input());
})->name('report.submit');
Route::view('/report', 'report', ['form' => "[
    {
        type: 'radio',
        name: 'compareStatus',
        required: true,
        title: 'Tegnaphoz képest értékelje saját állapotát:',
        description: 'Állapota tegnaphoz képest milyen irányba változott?',
        values: [{label:'Javult', value: 'better'}, {label: 'Nem változott', value: 'unchanged'}, {label: 'Romlott', value: 'worsened'}]
    },
    {
        type: 'checkbox',
        name: 'symptoms',
        title: 'Válassza ki az önre igaz tüneteket',
        description: 'Jelölje be az összes önre jellemző tünetet!',
        values: ['Szárazköhögés', 'Magas láz', 'Torokfájás']
    },
    {
        type: 'textarea',
        name: 'selfDiagnosis',
        title: 'Ha szükségét érzi, írja le saját szavaival, hogy érzi magát:'
    },
    {
        type: 'checkbox',
        title: 'Kötelező választani',
        name: 'smtg',
        required: true,
        values: ['Opció 1', 'Opció 2', 'Opció 3']
    }
]"]);
