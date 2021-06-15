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

	Route::prefix('users')->group(function(){
		Route::get('', 'User\UserController@index')->name('user.index');
		Route::post('/datatables', 'User\UserController@datatables')->name('user.datatables');
		Route::post('store', 'User\UserController@createOrUpdate')->name('user.createorupdate');
		Route::delete('delete/{id}', 'User\UserController@delete')->name('user.delete');
		Route::get('{id}', 'User\UserController@get')->name('user.get');
	});

	Route::prefix('agenda')->group(function(){
		Route::get('', 'Agenda\AgendaController@index')->name('agenda.index');
		Route::post('/datatables', 'Agenda\AgendaController@datatables')->name('agenda.datatables');
		Route::post('store', 'Agenda\AgendaController@createOrUpdate')->name('agenda.createorupdate');
		Route::delete('delete/{id}', 'Agenda\AgendaController@delete')->name('agenda.delete');
		Route::get('{id}', 'Agenda\AgendaController@get')->name('agenda.get');
	});


	Route::view('/', 'dashboard.index');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
