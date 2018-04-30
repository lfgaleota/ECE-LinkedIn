<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model 
{

    protected $table = 'notifications';
    public $timestamps = true;

    protected $primaryKey = 'notification_id';
    protected $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'notification_id',
        'user_id',
        'type',
        'read',
        'reaction_id',
        'comment_id',
        'friend_request_id',
    ];

}