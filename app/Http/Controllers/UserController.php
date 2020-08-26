<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Collective\Html\HtmlServiceProvider;
use App\User;
use App\Category;
use App\Tag;
use App\Comment;
use Auth;

class UserController extends Controller
{
    
	/**
	* Execute deletion for user
	*
	* @param  int $slug
	* @return redirect
	*/

	public function delete($slug)
	{
		if($slug and Auth::user()->id != $slug) abort(403);
		$user = User::where('id', $slug);
		$res = $user->delete();
		return redirect(route('user.list'));
	}

	/**
	* Generate view for user form
	*
	* @param  int $slug
	* @return template string
	*/

	public function form($slug = '')
	{
	  	//is edit  
	    if($slug){

	  		if(Auth::user()->id != $slug) abort(403);
	    	
		    //get the requested User, if it is published
		    $user = user::query()->where('id', $slug)->first();

		}		
		
	    //return the data to the corresponding view
	    return view('userform', array(
	        'user' => $user ?? [],	        
	    ));

	}

	/**
	* Generate view for post list
	*
	* @return redirect
	*/

	public function list()
	{
	  
	    //return the data to the corresponding view
	    return view('userform', array(
	        'ds' => User::all(),
	    ));

	}

	/**
	* Get user data and save it
	*
	* @param  int $slug
	* @return template string
	*/

	public function store(Request $request)
    {
    	//only allow to edit data for yourself
    	if($request->id and Auth::user()->id != $request->id) abort(403);

    	//validations
    	$this->validate(request(), [
            'name' => 'required',
            'email' => 'email|required|unique:users,email,'.$request->id,
            'password' => $request->password ? 'min:6|confirmed' : ''
        ]);
   		
   		$user = User::where('id', '=', $request->id)->first();
	    
	    $input['name'] = $request->name;
        $input['email'] = $request->email;
        //if password was submitted then encrypt it
        if($request->password){
      		$input['password'] = bcrypt($request->password);
      	}

      	//update if exists, or create
	    if ($user != null) {
	        $user->update($input);
	        return redirect(route('user.edit', $user->id))->withSuccess('Saved!');
	    } else {
        	$user = User::create($input);
        	return redirect(route('user.list'));
        }

        
    }
}

