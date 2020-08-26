<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Collective\Html\HtmlServiceProvider;
use App\Post;
use App\Category;
use App\Tag;
use App\Comment;
use TCG\Voyager\Models\User; //If you are using Voyager
use Auth;

class PostController extends Controller
{
    public function index($slug)
	{
	    //get the requested post, if it is published
	    $post = Post::query()->where('is_published', true)->where('slug', $slug)->first();

	    //get all the categories
	    $categories = Category::all();

	    //get all the tags
	    $tags = Tag::all();

	    //get the recent 5 posts
	    $recent_posts = Post::where('is_published',true)->orderBy('created_at','desc')->take(5)->get();

	    //comments for post
	    $comments = Comment::where('post_id',$post->id)->orderBy('created_at','desc')->get();

	    //return the data to the corresponding view
	    return view('post', array(
	        'post' => $post,
	        'categories' => $categories,
	        'tags' => $tags,
	        'recent_posts' => $recent_posts,
	        'comments' => $comments
	    ));
	}

	public function delete($slug)
	{
		$post = Post::where('id', $slug);
		$res = $post->delete();
		//dd($post);
		return redirect(route('post.list'));
	}

	public function form($slug = '')
	{
	  
	  	//is edit  
	    if($slug){

		    //get the requested post, if it is published
		    $post = Post::query()->where('id', $slug)->first();

		  	if($post){
		    //get all the tags
		   		$tags = implode(', ', $post->tags()->get()->pluck('name')->toArray());
		  	}
		}
		
		//get all the categories
		$categories = Category::pluck('name', 'id')->toArray();
	    
	    //return the data to the corresponding view
	    return view('postform', array(
	        'post' => $post ?? [],
	        'categoryList' => $categories ?? [],
	        'tags' => $tags ?? [],
	    ));
	}

	public function list()
	{
	  
	    //return the data to the corresponding view
	    return view('postform', array(
	        'ds' => Post::all(),
	    ));

	}

	public function store(Request $request)
    {
    	$request->validate([
            'title'=>'required',
            'slug'=>'required',
            'content'=>'required',
            'featured_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'featured_video' => 'max:100000',
        ]);
   
        $input = $request->all();
        $input['user_id'] = Auth::user() ? auth()->user()->id : 0;
        $input['is_published'] = 1;
    
    	 
	    $post = Post::where('slug', '=', $input['slug'])->first();
	    
	    if($request->featured_image){
		    $imageName = time().'.'.$request->featured_image->extension(); 	   
	        $request->featured_image->move($tmp = storage_path('app/public/images'), $imageName);
	       
	        $input['featured_image'] = 'images/'.$imageName;
	    }

	    if($request->featured_video){
		    $fileName = time().'.'.$request->featured_video->extension(); 	   
	        $request->featured_video->move($tmp = storage_path('app/public/videos'), $fileName);
	       
	        $input['featured_video'] = 'videos/'.$fileName;
	    }

	    //dd($input);
	    if ($post != null) {
	        $post->update($input);
	    } else {
        	$post = Post::create($input);
        }
         
        $tagsNames = explode(',', $request->get('tags'));
        $tagsNames = array_map('trim', $tagsNames);
        $tagsNames = array_filter($tagsNames);
        //dd($tagsNames);
	    // Create all tags (unassociet)
	    foreach($tagsNames as $tagName){
	    	
	    	$tag = Tag::where('slug', '=', str_slug($tagName))->first();
	    	if($tag){
	    		$tags [] = $tag->id;
	    	}
	    	if(!$tag){
	        	$tag = Tag::create(['name' => $tagName, 'slug' => str_slug($tagName)]);
	        	$tags [] = $tag->id;
	        }       
	        
	    }
   		if(isset($tags)){
   			$post->tags()->sync(array_unique($tags));
   		}
        return redirect(route('post.edit', $post->id))->withSuccess('Saved!');
    }
}

