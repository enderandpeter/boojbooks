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

Route::get('/', [
		'as' => 'home', 
		'uses' => 'HomeController@index']
);

Route::auth();

Route::get('/dashboard', [
		'as' => 'dashboard', 
		'uses' => 'DashboardController@index']
);

Route::resource('booklist', 'BooklistController');

Route::resource('booklist.book', 'BookController', [
		'parameters' => 'singular',
		'except' => [ 'index' ]
]);