<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model 
{

    protected $table = 'posts';
    public $timestamps = true;

    protected $primaryKey = 'post_id';
    protected $incrementing = false;

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