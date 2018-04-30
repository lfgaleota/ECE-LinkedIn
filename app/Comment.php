<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model 
{

    protected $table = 'comments';
    public $timestamps = true;

    protected $primaryKey = 'comment_id';
    protected $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comment_id',
        'post_id',
        'author_id',
        'text',
    ];

    public function getPost()
    {
        return $this->belongsTo('Post', 'post_id');
    }

    public function getAuthor()
    {
        return $this->belongsTo('User', 'author_id');
    }

    public function getReactions()
    {
        return $this->hasMany('Reaction');
    }

}