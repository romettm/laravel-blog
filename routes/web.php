<?php

use App\Task;
use Illuminate\Http\Request;

/*
Route::get('/', function () {
    
    $tasks = Task::orderBy('created_at', 'asc')->get();
    return view('tasks', [
        'tasks' => $tasks
    ]);

});

Route::post('/task', function (Request $request) {

    $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',
    ]);

    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }

    $task = new Task;
    $task->name = $request->name;
    $task->save();

    return redirect('/');

});

Route::delete('/task/{id}', function ($id) {
    Task::findOrFail($id)->delete();
    return redirect('/');
});
*/

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});


Route::get('/', 'IndexController@index');
Route::get('category/{slug}', 'CategoryController@index');
Route::get('tag/{slug}', 'TagController@index');
Route::get('post/{slug}', 'PostController@index');