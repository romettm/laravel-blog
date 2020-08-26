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

	Route::get('post-list', 'postController@list')->name('post.list');
	Route::get('post-new', 'postController@form')->name('post.new');
	Route::get('post-edit/{slug}', 'postController@form')->name('post.edit');
	Route::get('post-delete/{slug}', 'postController@delete')->name('post.delete');
	Route::post('post-submit', 'postController@store')->name('post.store');

	Route::get('user-list', 'userController@list')->name('user.list');
	Route::get('user-new', 'userController@form')->name('user.new');
	Route::get('user-edit/{slug}', 'userController@form')->name('user.edit');
	Route::get('user-delete/{slug}', 'userController@delete')->name('user.delete');
	Route::post('user-submit', 'userController@store')->name('user.store');
	
});




