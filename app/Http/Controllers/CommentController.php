<?php
   
namespace App\Http\Controllers;
   
use Illuminate\Http\Request;
use App\Comment;
use Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$request->validate([
            'content'=>'required',
        ]);
   
        $input = $request->all();
        $input['user_id'] = Auth::user() ? auth()->user()->id : 0;
    
        Comment::create($input);
   
        return back()->withSuccess('Saved!');
    }
}