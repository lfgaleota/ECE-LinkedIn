<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model 
{

    protected $table = 'conversations';
    public $timestamps = false;

    protected $primaryKey = 'conversation_id';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'conversation_id',
        'message_id',
    ];

}