<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Collective\Html\HtmlServiceProvider;
use App\User;
use App\Category;
use App\Tag;
use App\Comment;
//use TCG\Voyager\Models\User; //If you are using Voyager
use Auth;

class UserController extends Controller
{
    

	public function delete($slug)
	{
		$user = User::where('id', $slug);
		$res = $user->delete();
		return redirect(route('user.list'));
	}

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

	public function list()
	{
	  
	    //return the data to the corresponding view
	    return view('userform', array(
	        'ds' => User::all(),
	    ));

	}

	public function store(Request $request)
    {
    	if($request->id and Auth::user()->id != $request->id) abort(403);

    	$this->validate(request(), [
            'name' => 'required',
            'email' => 'email|required|unique:users,email,'.$request->id,
            'password' => $request->password ? 'min:6|confirmed' : ''
        ]);
   		
   		$user = User::where('id', '=', $request->id)->first();
	    
	    $input['name'] = $request->name;
        $input['email'] = $request->email;
        if($request->password){
      		$input['password'] = bcrypt($request->password);
      	}
	    if ($user != null) {
	        $user->update($input);
	    } else {
        	$user = User::create($input);
        }

        return redirect(route('user.edit', $user->id))->withSuccess('Saved!');
    }
}

