<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'slug',
    ];

    /**
	 * Get the posts for the cat.
	 */
	public function posts()
	{
        $tmp = $this->hasMany('App\Post')->get();
	    return $tmp;
	}

}