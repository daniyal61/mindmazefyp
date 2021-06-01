<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/





Route::post('user/signup', 'UserApiController@signup');
Route::post('user/login', 'UserApiController@userlogin');
Route::post('user/logout', 'UserApiController@userlogout');
Route::get('/user/profile' , 'UserApiController@get_user_profile');
Route::post('/update-user/profile/{id}' ,'UserApiController@update_profile_user');

Route::post('/user/forgot-password','UserApiController@forgotPassword');
Route::get('forgot-user-password/{token}', 'UserApiController@showforgotPassword');
Route::patch('update_password/{email}', 'UserApiController@updatePassword');

Route::get('user_verification/{email}', 'UserApiController@userEmailVerification');

Route::get('quizz/codes', 'UserApiController@getquizzcodes');
Route::get('get/quizz', 'UserApiController@getquizz');
Route::post('answer/quizz', 'UserApiController@answerquizz');

Route::get('/scores', 'UserApiController@getscores');


Route::post('Api/store', 'ApiController@store')->name('store');
Route::post('Api/login', 'ApiController@login')->name('login');

