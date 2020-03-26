<?php

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
    return "";
});


Route::get('/submit', 'SubmissionController@index');
Route::post('/submit/documents', 'SubmissionController@submitDocuments')->name('company.infoupload');
Route::post('/submit/form', 'SubmissionController@submitForm')->name('company.submitform');