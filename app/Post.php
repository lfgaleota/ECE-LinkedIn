<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

/**
 * App\Post
 *
 * @property int $post_id
 * @property int $author_id
 * @property int|null $event_id
 * @property string $type
 * @property string|null $location
 * @property string|null $mood
 * @property string|null $image_url
 * @property string|null $video_url
 * @property string $visibility
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereMood($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereVisibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereVideoUrl($value)
 * @mixin \Eloquent
 */
class Post extends Model 
{

	protected $table = 'posts';
    public $timestamps = true;

    protected $primaryKey = 'post_id';
    public $incrementing = false;

	const CREATED_AT = 'posts.created_at';
	const UPDATED_AT = 'posts.updated_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    const select = [
        'post_id',
        'author_id',
        'event_id',
        'type',
	    'description',
        'location',
        'mood',
        'image_url',
        'video_url',
        'visibility',
    ];

	const select_more = [
		'created_at',
		'updated_at'
	];

	const jsonVars = [ 'photo_ids', 'video_ids', 'post_visibility_user_ids' ];

	protected $fillable = Post::select;

	const validation = [
		'post_id' => 'required|unique:posts|numeric',
		'author_id' => 'required|numeric',
		'event_id' => 'numeric',
		'type' => 'required|string',
		'description' => 'string',
		'location' => 'string',
		'mood' => 'string',
		'image_url' => 'string',
		'image' => 'mimes:jpeg,png',
		'video' => 'mimes:video/avi,video/mpeg,video/quicktime,video/mp4,video/ogg,video/webm',
		'video_url' => 'string',
		'visibility' => 'required|string',
		'photo_ids' => 'json',
		'video_ids' => 'json',
		'post_visibility_user_ids' => 'json'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	public function newEloquentBuilder( $query ) {
		return parent::newEloquentBuilder( $query )
			->join( 'users AS authors', 'posts.author_id', '=', 'authors.user_id' );
	}

    public function getAuthor()
    {
        return \App\User::find( $this->author_id );
    }

    public function getEvent()
    {
        return $this->hasOne('Event', 'event_id');
    }

    public function getComments()
    {
        return $this->hasMany('Comment');
    }

    public function getReactions()
    {
        return $this->hasMany('Reaction');
    }

    public function getAuthorizedUsers()
    {
        return $this->belongsToMany('User', 'post_visibility', 'user_id', 'post_id');
    }

    public function getSubPosts()
    {
        return $this->belongsToMany('Post', 'sub_post', 'child_post_id', 'parent_post_id');
    }

    public function setSubPosts( array $post_ids ) {
    	DB::table( 'sub_posts' )->where( 'parent_post_id', '=', $this->post_id )->delete();

	    foreach( $post_ids as $post_id ) {
		    DB::table( 'sub_posts' )->insert([
			    'parent_post_id' => $this->post_id,
			    'child_post_id' => $post_id
		    ]);
	    }
    }

	public function setPostVisibility( array $user_ids ) {
		DB::table( 'post_visibilities' )->where( 'post_id', '=', $this->post_id )->delete();

		foreach( $user_ids as $user_id ) {
			DB::table( 'post_visibilities' )->insert([
				'post_id' => $this->post_id,
				'user_id' => $user_id
			]);
		}
	}
}