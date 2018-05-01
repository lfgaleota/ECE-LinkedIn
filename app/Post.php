<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
 * @property int $public
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereMood($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post wherePublic($value)
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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id',
        'author_id',
        'event_id',
        'type',
        'location',
        'mood',
        'image_url',
        'video_url',
        'public',
    ];

    public function getAuthor()
    {
        return $this->belongsTo('User', 'author_id');
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

}