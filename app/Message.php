<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Message
 *
 * @property int $message_id
 * @property int $author_id
 * @property string $type
 * @property string $content
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereMessageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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