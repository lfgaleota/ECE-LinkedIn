<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reaction extends Model 
{

    protected $table = 'reactions';
    public $timestamps = true;

    protected $primaryKey = 'reaction_id';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id',
        'comment_id',
        'author_id',
        'type',
    ];

    public function getPost()
    {
        return $this->belongsTo('Post', 'post_id');
    }

    public function getComment()
    {
        return $this->belongsTo('Comment', 'comment_id');
    }

    public function getAuthor()
    {
        return $this->belongsTo('User', 'author_id');
    }

}