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
        values: [{label:'Javult', value: 'better'}, {label: 'Nem változott', value: 'unchanged'}, {label: 'Romlott', value: 'worsened'}]
    },
    {
        type: 'radio',
        required: true,
        name: 'symptoms',
        title: 'Van-e láza? Ha igen, láza 37,8 C° felett van-e?',
        values: [{label: 'Nem', value: 'false'}, {label: 'Igen', value: 'true'}],
        imageUrl: 'https://koronavirusteszt.info/public/images/fever.svg'
    },
    {
        type: 'radio',
        required: true,
        name: 'cough',
        title: 'Van-e szárazköhögése?',
        values: [{label: 'Nem', value: 'false'}, {label: 'Igen', value: 'true'}],
        imageUrl: 'https://koronavirusteszt.info/public/images/cough.svg'
    },
    {
        type: 'radio',
        required: true,
        name: 'fatigue',
        title: 'Jelentősen fáradtabbnak érzi magát, mint általában?',
        values: [{label: 'Nem', value: 'false'}, {label: 'Igen', value: 'true'}],
        imageUrl: 'https://koronavirusteszt.info/public/images/fatigue.svg'
    },
    {
        type: 'radio',
        required: true,
        name: 'no_appetite',
        title: 'Tapasztal-e étvágytalanságot?',
        values: [{label: 'Nem', value: 'false'}, {label: 'Igen', value: 'true'}],
        imageUrl: 'https://koronavirusteszt.info/public/images/no_appetite.svg'
    },
    {
        type: 'radio',
        required: true,
        name: 'breathing_difficulty',
        title: 'Vannak-e légzési nehézségei?',
        values: [{label: 'Nem', value: 'false'}, {label: 'Igen', value: 'true'}],
        imageUrl: 'https://koronavirusteszt.info/public/images/difficulty_breathing.svg'
    },
    {
        type: 'radio',
        required: true,
        name: 'sputum',
        title: 'Tapasztal-e köpetürítést vagy váladékos köhögést?',
        values: [{label: 'Nem', value: 'false'}, {label: 'Igen', value: 'true'}],
        imageUrl: 'https://koronavirusteszt.info/public/images/sputum.svg'
    },
    {
        type: 'radio',
        required: true,
        name: 'body_pain',
        title: 'Tapasztal-e izom- vagy csontfájdalmat?',
        values: [{label: 'Nem', value: 'false'}, {label: 'Igen', value: 'true'}],
        imageUrl: 'https://koronavirusteszt.info/public/images/body_pain.svg'
    },
    {
        type: 'radio',
        required: true,
        name: 'sore_throat',
        title: 'Tapasztal-e torokfájást?',
        values: [{label: 'Nem', value: 'false'}, {label: 'Igen', value: 'true'}],
        imageUrl: 'https://koronavirusteszt.info/public/images/sore_throat.svg'
    },
    {
        type: 'radio',
        required: true,
        name: 'headache',
        title: 'Tapasztal-e fejfájást vagy szédülést?',
        values: [{label: 'Nem', value: 'false'}, {label: 'Igen', value: 'true'}],
        imageUrl: 'https://koronavirusteszt.info/public/images/headache.svg'
    },
    {
        type: 'radio',
        required: true,
        name: 'confusion',
        title: 'Tapasztal-e zavartságot?',
        values: [{label: 'Nem', value: 'false'}, {label: 'Igen', value: 'true'}],
        imageUrl: 'https://koronavirusteszt.info/public/images/confusion.svg'
    },
    {
        type: 'radio',
        required: true,
        name: 'chills',
        title: 'Tapasztal-e hidegrázást?',
        values: [{label: 'Nem', value: 'false'}, {label: 'Igen', value: 'true'}],
        imageUrl: 'https://koronavirusteszt.info/public/images/chills.svg'
    },
    {
        type: 'radio',
        required: true,
        name: 'nausea',
        title: 'Van-e hányingere vagy hasmenése?',
        values: [{label: 'Nem', value: 'false'}, {label: 'Igen', value: 'true'}],
        imageUrl: 'https://koronavirusteszt.info/public/images/nausea.svg'
    },
    {
        type: 'radio',
        required: true,
        name: 'chronic',
        title: 'Van-e krónikus betegsége? (Rizikófaktor)',
        values: [{label: 'Nem', value: 'false'}, {label: 'Igen', value: 'true'}],
        imageUrl: 'https://koronavirusteszt.info/public/images/chronic.svg'
    },
    {
        type: 'radio',
        required: true,
        name: 'heart',
        title: 'Tapasztal-e mellkasi fájdalmat/mellkasi nyomást vagy szabálytalan szívverést?',
        values: [{label: 'Nem', value: 'false'}, {label: 'Igen', value: 'true'}],
        imageUrl: 'https://koronavirusteszt.info/public/images/heart.svg'
    },
    {
        type: 'radio',
        required: true,
        name: 'blue',
        title: 'Kékes színű-e az ajka, arca?',
        values: [{label: 'Nem', value: 'false'}, {label: 'Igen', value: 'true'}],
        imageUrl: 'https://koronavirusteszt.info/public/images/blue.svg'
    },
    {
        type: 'radio',
        required: true,
        name: 'no_smell',
        title: 'Elvesztette-e az ízlését vagy szaglását?',
        values: [{label: 'Nem', value: 'false'}, {label: 'Igen', value: 'true'}],
        imageUrl: 'https://koronavirusteszt.info/public/images/no_smell.svg'
    },
    {
        type: 'radio',
        required: true,
        name: 'age_risk',
        title: 'Idősebb-e mint 50 vagy fiatalabb mint 5? (Rizikófaktor)?',
        values: [{label: 'Nem', value: 'false'}, {label: 'Igen', value: 'true'}],
        imageUrl: 'https://koronavirusteszt.info/public/images/man_and_child.svg'
    },
    {
        type: 'textarea',
        name: 'selfDiagnosis',
        title: 'Ha szükségét érzi, írja le saját szavaival, hogy érzi magát:'
    },
]"]);
