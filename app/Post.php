<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
	    'category_id',
	    'user_id',
	    "title",
	    'content',
	    'slug',
	    'featured_image',
	    'is_featured',
	    'is_published'
	];

	/**
	 * Get the user that owns the post.
	 */
	public function user()
	{
	    return $this->belongsTo('App\User');
	}

	/**
	 * Get the category that owns the post.
	 */
	public function category()
	{
	    return $this->belongsTo('App\Category');
	}

	public function tags()
	{
	    return $this->belongsToMany('App\Tag');
	}

}
