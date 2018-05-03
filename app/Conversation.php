<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Conversation
 *
 * @property int $conversation_id
 * @property int $message_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Conversation whereConversationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Conversation whereMessageId($value)
 * @mixin \Eloquent
 */
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