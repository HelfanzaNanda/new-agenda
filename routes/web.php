<?php

use Illuminate\Support\Facades\{Auth, Route};

Route::view('/login', 'auth.login')->name('login');

Route::get('password-reset', 'User\ForgotPasswordController@showLinkRequestForm')->name('user.password.request');
Route::post('password-email', 'User\ForgotPasswordController@sendResetLinkEmail')->name('user.password.email');
Route::get('password-reset/{token}', 'User\ResetPasswordController@showResetForm')->name('user.password.reset');
Route::post('password-reset', 'User\ResetPasswordController@reset')->name('user.password.update');


Route::middleware('auth')->group(function(){

	Route::get('update-password', 'User\UpdatePasswordController@index')->name('update.password');
	Route::post('update-password', 'User\UpdatePasswordController@update');



	Route::view('/', 'dashboard.index');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
