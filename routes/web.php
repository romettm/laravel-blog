<?php

use App\Task;
use Illuminate\Http\Request;

Auth::routes();


Route::get('/', 'IndexController@index');
Route::get('/home', 'IndexController@index');
Route::get('search', 'IndexController@search');

Route::get('category/{slug}', 'CategoryController@index');
Route::get('tag/{slug}', 'TagController@index');
Route::get('post/{slug}', 'PostController@index');
Route::post('comment/store', 'commentController@store')->name('comment.store');

Route::group(['middleware' => 'auth'], function() {

	Route::get('post-list', 'PostController@list')->name('post.list');
	Route::get('post-new', 'PostController@form')->name('post.new');
	Route::get('post-edit/{slug}', 'PostController@form')->name('post.edit');
	Route::get('post-delete/{slug}', 'PostController@delete')->name('post.delete');
	Route::post('post-submit', 'PostController@store')->name('post.store');

	Route::get('user-list', 'UserController@list')->name('user.list');
	Route::get('user-new', 'UserController@form')->name('user.new');
	Route::get('user-edit/{slug}', 'UserController@form')->name('user.edit');
	Route::get('user-delete/{slug}', 'UserController@delete')->name('user.delete');
	Route::post('user-submit', 'UserController@store')->name('user.store');
	
});




