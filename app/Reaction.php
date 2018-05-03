<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Reaction
 *
 * @property int $reaction_id
 * @property int|null $post_id
 * @property int|null $comment_id
 * @property int $author_id
 * @property string $type
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reaction whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reaction whereCommentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reaction wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reaction whereReactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reaction whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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