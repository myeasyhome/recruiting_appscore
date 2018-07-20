<?php

use Illuminate\Support\Facades\Redirect;

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
    return Redirect::route('login');
});

Route::get('candidate/add', 'CandidateController@create')->name('candidateCreate');

Route::post('candidate/store', 'CandidateController@store')->name('candidateCreated');

Route::get('candidate/{candidate_id}', 'CandidateController@edit')->name('candidateUpdate');

Route::post('candidate/{candidate_id}', 'CandidateController@update')->name('candidateUpdated');

Route::post('/home', 'CandidateController@query')->name('candidateQuery');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');