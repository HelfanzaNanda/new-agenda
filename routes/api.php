<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::namespace('API')->group(function() {
	Route::post('login', 'User\LoginController@login');

	Route::middleware('auth:api')->group(function(){
		Route::prefix('agenda')->group(function(){
			Route::get('/', 'Agenda\AgendaController@index');
			Route::get('/{id}/detail', 'Agenda\AgendaController@detail');
		});
		Route::prefix('absen')->group(function(){
			Route::post('/store', 'Absen\AbsenController@store');
		});
		
		Route::prefix('user')->group(function(){
			Route::get('/disposisi', 'User\UserController@showDisposisi');
		});
	});
});



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
