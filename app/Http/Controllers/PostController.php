<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Collective\Html\HtmlServiceProvider;
use App\Post;
use App\Category;
use App\Tag;
use App\Comment;

use Auth;

class PostController extends Controller
{
	 /**
     * Generate view data for home page
     *
     * @param  string $slug
     * @return template string
     */
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

	/**
	* Execute deletion for post
	*
	* @param  int $slug
	* @return redirect
	*/
	public function delete($slug)
	{
		$post = Post::where('id', $slug);
		$res = $post->delete();
		//dd($post);
		return redirect(route('post.list'));
	}

	/**
	* Generate view for post form
	*
	* @param  int $slug
	* @return template string
	*/

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

	/**
	* Generate view for post list
	*
	* @return redirect
	*/

	public function list()
	{
	  
	    //return the data to the corresponding view
	    return view('postform', array(
	        'ds' => Post::all(),
	    ));

	}

	/**
	* Get post data and save it
	*
	* @param  int $slug
	* @return template string
	*/
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
        $input['user_id'] = Auth::user()->id;
        $input['is_published'] = 1; //at the moment no button, so we set it manually    
    	 
    	//get post from database
	    $post = Post::where('id', '=', $input['id'])->first();
	    
	    //save image if there is one
	    if($request->featured_image){
		    $imageName = time().'.'.$request->featured_image->extension(); 	   
	        $request->featured_image->move($tmp = storage_path('app/public/images'), $imageName);	       
	        $input['featured_image'] = 'images/'.$imageName;
	    }

	    //save video if there is one
	    if($request->featured_video){
		    $fileName = time().'.'.$request->featured_video->extension(); 	   
	        $request->featured_video->move($tmp = storage_path('app/public/videos'), $fileName);
	       
	        $input['featured_video'] = 'videos/'.$fileName;
	    }

	    //save post 
	    if ($post != null) {
	        $post->update($input);
	    } else {
        	$post = Post::create($input);
        }
         
        //save tags

        $tagsNames = explode(',', $request->get('tags'));
        $tagsNames = array_map('trim', $tagsNames);
        $tagsNames = array_filter($tagsNames);
        
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

	    //sync relations
   		if(isset($tags)){
   			$post->tags()->sync(array_unique($tags));
   		}

        return redirect(route('post.edit', $post->id))->withSuccess('Saved!');
    }
}

