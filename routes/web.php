<?php

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

Route::get('/', function () {
    return view('welcome');
});

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
        type: 'checkbox',
        name: 'symptoms',
        title: 'Válassza ki az önre igaz tüneteket',
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
