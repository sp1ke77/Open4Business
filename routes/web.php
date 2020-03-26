<?php
declare(strict_types=1);

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
    return '';
});




Auth::routes([
    'verify' => false,
    'register' => false,
    'reset' => false
]);

Route::prefix('mass_submission')->middleware(['auth'])->name('mass_submission.')->group(function () {
    Route::get('/', 'MassSubmissionController@index')->name('index');
    Route::post('/documents', 'MassSubmissionController@submitDocuments')->name('infoupload');
    Route::post('/form', 'MassSubmissionController@submitForm')->name('submitform');
});

Route::prefix('backoffice')->middleware(['auth'])->namespace('Backoffice')->name('backoffice.')->group(function () {
    Route::get('/', 'HomeController@index')->name('index');
    Route::prefix('users')->middleware(['teamUser'])->name('users.')->group(function () {
        Route::get('/', 'UsersController@index')->name('index');
        Route::get('/new', 'UsersController@new')->name('new');
        Route::get('/edit/{id}', 'UsersController@edit')->name('edit');
        Route::post('/create', 'UsersController@create')->name('create');
        Route::post('/update', 'UsersController@update')->name('update');
        Route::post('/delete', 'UsersController@delete')->name('delete');
    });
});