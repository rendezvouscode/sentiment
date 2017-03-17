<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});
//route get
Route::get('home', 'DataTrainingController@index');
Route::get('jajal', 'DataTrainingController@preprocessing');
Route::get('home/testing','DataTrainingController@show_testing');
Route::get('home/persentasi','DataTrainingController@presentase_testing');
Route::get('home/pengujian','PengujianMetodeController@uji');

// Route post
Route::post('home/testing','DataTrainingController@store_testing');
Route::post('home','DataTrainingController@store_training');
//Route Delete
Route::delete('home/{home}','DataTrainingController@destroy_training');
Route::delete('home/testing/{home}','DataTrainingController@destroy_testing');
