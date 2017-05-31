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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::any('student/uploads',['uses'=>'StudentController@uploads']);

Route::any('mail',['uses'=>'StudentController@mail']);

Route::any('cache1',['uses'=>'StudentController@cache1']);

Route::any('cache2',['uses'=>'StudentController@cache2']);

Route::any('error',['uses'=>'StudentController@error']);

Route::any('queue',['uses'=>'StudentController@queue']);

Route::get('request/{id?}','StudentController@getBasetest')->where('id','[0-9]');

Route::any('request/getMethod',['uses'=>'StudentController@getMethod']);

Route::any('request/url',['uses'=>'StudentController@getUrl']);

Route::any('request/getInputData',['uses'=>'StudentController@getInputData']);

Route::any('request/getLastRequest',['uses'=>'StudentController@getLastRequest']);

Route::any('request/getCurrentRequest',['uses'=>'StudentController@getCurrentRequest']);

Route::any('request/session1',['uses'=>'StudentController@session1']);

Route::any('request/session2',['uses'=>'StudentController@session2']);

Route::any('request/getCookie',['uses'=>'StudentController@getCookie']);

Route::any('request/getAddCookie',['uses'=>'StudentController@getAddCookie']);

Route::any('request/getFileupload',['uses'=>'StudentController@getFileupload']);

Route::post('request/fileupload',"StudentController@postFileupload");








