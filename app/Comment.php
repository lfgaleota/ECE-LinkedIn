<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Comment
 *
 * @property int $comment_id
 * @property int $post_id
 * @property int $author_id
 * @property string $text
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereCommentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Comment extends Model 
{

	protected $table = 'comments';
    public $timestamps = true;

    protected $primaryKey = 'comment_id';
    public $incrementing = false;

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

	/**
	 * The attributes that should be validated and their respective format
	 */
	const validation = [
		'comment_id' => 'required|numeric|unique:comments',
		'post_id' => 'required|numeric',
		'author_id' => 'required|numeric',
		'text' => 'required|string'
	];

    public function getPost()
    {
        return $this->belongsTo('Post', 'post_id');
    }

    public function author()
    {
        return $this->belongsTo('\App\User', 'author_id');
    }

    public function getReactions()
    {
        return $this->hasMany('Reaction');
    }

}