<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model 
{

    protected $table = 'messages';
    public $timestamps = true;

    protected $primaryKey = 'reaction_id';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message_id',
        'author_id',
        'type',
        'content',
    ];

    public function getAuthor()
    {
        return $this->belongsTo('User', 'author_id');
    }

}