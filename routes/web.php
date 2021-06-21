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

	Route::get('/', 'Dashboard\DashboardController@index')->name('dashboard.index');
	Route::get('/full-screen', 'Dashboard\DashboardController@fullScreen')->name('dashboard.full.screen');
	Route::post('/', 'Dashboard\DashboardController@datatables')->name('dashboard.datatables');

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
		Route::get('/autocomplete/pelaksana','Agenda\AgendaController@get')->name('agenda.search');
		Route::get('create', 'Agenda\AgendaController@create')->name('agenda.create');
		Route::post('create', 'Agenda\AgendaController@store');
		Route::get('edit/{id}', 'Agenda\AgendaController@edit')->name('agenda.edit');
		Route::post('edit/{id}', 'Agenda\AgendaController@update');
		Route::get('detail/{id}', 'Agenda\AgendaController@detail')->name('agenda.detail');
		Route::delete('delete/{id}', 'Agenda\AgendaController@delete')->name('agenda.delete');
		Route::post('download', 'Agenda\AgendaController@download')->name('agenda.download');
		
		Route::post('store', 'User\UserController@createOrUpdate')->name('agenda.createorupdate');
		Route::get('{id}', 'User\UserController@get')->name('agenda.get');
	});

	Route::prefix('report')->group(function(){
		Route::prefix('agenda')->group(function(){
			Route::get('/', 'Report\Agenda\AgendaController@index')->name('report.agenda.index');
			Route::post('/', 'Report\Agenda\AgendaController@datatables')->name('report.agenda.datatables');
			Route::post('/pdf', 'Report\Agenda\AgendaController@pdf')->name('report.agenda.pdf');
		});
	});

	Route::prefix('disposisi')->group(function(){
		Route::get('', 'Disposisi\DisposisiController@index')->name('disposisi.index');
		Route::post('/datatables', 'Disposisi\DisposisiController@datatables')->name('disposisi.datatables');
		Route::get('create/{agenda_id?}', 'Disposisi\DisposisiController@create')->name('disposisi.create');
		Route::post('store', 'Disposisi\DisposisiController@store')->name('disposisi.store');
		Route::get('edit/{id}', 'Disposisi\DisposisiController@edit')->name('disposisi.edit');
		Route::post('edit/{id}', 'Disposisi\DisposisiController@update');
		Route::get('detail/{id}', 'Disposisi\DisposisiController@detail')->name('disposisi.detail');
		Route::delete('delete/{id}', 'Disposisi\DisposisiController@delete')->name('disposisi.delete');
		Route::get('download', 'Disposisi\DisposisiController@download')->name('disposisi.download');
		Route::get('generate', 'Disposisi\DisposisiController@generateNumber')->name('disposisi.generate.number');
		
		Route::get('{id}', 'User\UserController@get')->name('disposisi.get');
	});

	
});

Route::get('number/generate', 'NumberGenerate\NumberGenerateController@generate')->name('number.generate');
Route::get('number/validate', 'NumberGenerate\NumberGenerateController@validateNumber')->name('number.validate');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
