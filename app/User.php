<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    public $timestamps = true;

    protected $primaryKey = 'user_id';
    protected $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'surname',
        'username',
        'email',
        'role',
        'birth_date',
        'title',
        'cv_url',
        'photo_id',
        'cover_id',
        'remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getPhoto()
    {
        return $this->hasOne('Post', 'photo_id');
    }

    public function getCover()
    {
        return $this->hasOne('Post', 'cover_id');
    }

    public function getConversations()
    {
        return $this->belongsToMany('Conversation', 'conversation_member', 'user_id', 'conversation_id');
    }

    public function getFriends()
    {
        return $this->belongsToMany('User', 'friend', 'friend2_id', 'friend1_id');
    }

    public function getFriendRequests()
    {
        return $this->hasMany('FriendRequest', 'invited_id');
    }

    public function getNotifications()
    {
        return $this->hasMany('Notification');
    }

}