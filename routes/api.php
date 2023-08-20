<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\TokenAuthenticationMiddleware;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/login', 'App\Http\Controllers\AuthController@login');


Route::middleware(['token.auth'])->group(function () {
    // Your secured routes here
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/students', 'App\Http\Controllers\StudentsController@index');
    Route::get('/raisons', 'App\Http\Controllers\RaisonsController@index');
    Route::post('/raisons', 'App\Http\Controllers\RaisonsController@store');
    Route::delete('/raisons/{id}', 'App\Http\Controllers\RaisonsController@destroy');


    Route::get('/students/{id}', 'App\Http\Controllers\StudentsController@show');
    Route::post('/students', 'App\Http\Controllers\StudentsController@store');
    Route::delete('/students/{id}', 'App\Http\Controllers\StudentsController@destroy');

    Route::get('/old-students', 'App\Http\Controllers\StudentsController@getOldStudentsindex');

    Route::get('/students/absence-hours/{id}/{school_year_id}', 'App\Http\Controllers\StudentsController@getStudentAbsenceHours');

    Route::post('/students/edit/{id}', 'App\Http\Controllers\StudentsController@update');
    Route::put('/deleted-students/edit/{id}', 'App\Http\Controllers\StudentsController@updateDeletedStudents');


    Route::get('/students/docs/{id}', 'App\Http\Controllers\StudentsController@getStudentDocs');
    Route::post('/students/docs', 'App\Http\Controllers\StudentsController@storeStudentDocs');
    Route::delete('/students/docs/{id}', 'App\Http\Controllers\StudentsController@destroyStudentDocs');


    Route::post('/tutors', 'App\Http\Controllers\TutorsController@store');
    Route::delete('/tutors/{id}', 'App\Http\Controllers\TutorsController@destroy');

    Route::get('/home/{school_year_id}', 'App\Http\Controllers\InstallmentsController@getHomeData');

    Route::post('/installments', 'App\Http\Controllers\InstallmentsController@store');
    Route::put('/installments/{id}', 'App\Http\Controllers\InstallmentsController@update');
    Route::delete('/installments/{id}', 'App\Http\Controllers\InstallmentsController@destroy');

    Route::post('/inscriptions', 'App\Http\Controllers\InscriptionsController@store');
    Route::put('/inscriptions/{id}', 'App\Http\Controllers\InscriptionsController@update');
    Route::delete('/inscriptions/{id}', 'App\Http\Controllers\InscriptionsController@destroy');

    Route::post('/absences', 'App\Http\Controllers\AbsencesController@store');
    Route::put('/absences/{id}', 'App\Http\Controllers\AbsencesController@update');
    Route::delete('/absences/{id}', 'App\Http\Controllers\AbsencesController@destroy');

    Route::post('/retards', 'App\Http\Controllers\RetardsController@store');
    Route::put('/retards/{id}', 'App\Http\Controllers\RetardsController@update');
    Route::delete('/retards/{id}', 'App\Http\Controllers\RetardsController@destroy');

    Route::get('/classes', 'App\Http\Controllers\ClassesController@index');

    Route::get('/groups', 'App\Http\Controllers\GroupsController@index');
    Route::post('/groups', 'App\Http\Controllers\GroupsController@store');
    Route::delete('/groups/{id}', 'App\Http\Controllers\GroupsController@destroy');

    Route::get('/school-years', 'App\Http\Controllers\SchoolYearsController@index');


    Route::get('/expenses', 'App\Http\Controllers\ExpensesController@index');
    Route::post('/expenses', 'App\Http\Controllers\ExpensesController@store');
    Route::delete('/expenses/{id}', 'App\Http\Controllers\ExpensesController@destroy');

    Route::get('/expenses-types', 'App\Http\Controllers\ExpensesTypesController@index');
});




// ... other secured routes ...