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

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');


Auth::routes([
    'verify'   => false,
    'register' => false,
    'reset'    => true,
]);


Route::get('/validate_token/{validation_token}', 'Backoffice\UsersController@validate_token');
	Route::post('/validate_token', 'Backoffice\UsersController@validation')->name('validate_token');
Route::get('/request_user', 'Backoffice\UsersController@request_user_view')->name('request_user');
Route::post('/request_user', 'Backoffice\UsersController@request_user');



Route::prefix('single_submission')->name('single_submission.')->group(function () {
    Route::get('/', 'SingleSubmissionController@index')->name('index');
    Route::post('/submit', 'SingleSubmissionController@submit')->name('submit');
    Route::get('/validate_token/{validation_token}', 'SingleSubmissionController@validate_token');
    Route::post('/validate_token', 'SingleSubmissionController@validation')->name('validate_token');
});


Route::prefix('mass_submission')->middleware(['auth','bigCompanyUser'])->name('mass_submission.')->group(function () {
    Route::get('/', 'MassSubmissionController@index')->name('index');
    Route::post('/documents', 'MassSubmissionController@submitDocuments')->name('infoupload');
    Route::post('/form', 'MassSubmissionController@submitForm')->name('submitform');
});

Route::prefix('backoffice')->middleware(['auth'])->namespace('Backoffice')->name('backoffice.')->group(function () {
    Route::get('/', 'HomeController@index')->name('index');
    Route::post('/password', 'HomeController@updatePassword')->name('password');
    Route::prefix('users')->middleware(['teamUser'])->name('users.')->group(function () {
        Route::get('/', 'UsersController@index')->name('index');
        Route::get('/new', 'UsersController@new')->name('new');
        Route::get('/edit/{id}', 'UsersController@edit')->name('edit');
        Route::post('/create', 'UsersController@create')->name('create');
        Route::post('/update', 'UsersController@update')->name('update');
        Route::post('/authorize', 'UsersController@authorized')->name('authorize');
        Route::post('/delete', 'UsersController@delete')->name('delete');
    });
    Route::prefix('submissions')->middleware([])->name('submissions.')->group(function () {
        Route::get('/', 'SubmissionsController@index')->name('index');
        Route::get('/{id}', 'SubmissionsController@entries')->name('entries');
        Route::get('/{submission}/entries/{entry}', 'SubmissionsController@edit')->name('entries.edit');
        Route::post('/{submission}/entries/{entry}', 'SubmissionsController@update')->name('entries.update');
        Route::get('/schedules/{id}', 'SubmissionsController@schedules')->name('schedules');
        Route::post('/entries/delete', 'SubmissionsController@entries_delete')->name('entries.delete');
        Route::post('/schedules/delete', 'SubmissionsController@schedules_delete')->name('schedules.delete');
        Route::post('/validate', 'SubmissionsController@validation')->name('validate');
        Route::post('/delete', 'SubmissionsController@delete')->name('delete');
    });
    Route::prefix('businesses')->middleware(['teamUser'])->name('businesses.')->group(function () {
        Route::get('/', 'BusinessesController@index')->name('index');
        Route::get('/schedules/{id}', 'BusinessesController@schedules')->name('schedules');
        Route::post('/schedules/delete', 'BusinessesController@schedules_delete')->name('schedules.delete');
        Route::post('/delete', 'BusinessesController@delete')->name('delete');
    });

});
