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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reaction whereAuthorId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reaction whereCommentId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reaction whereCreatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reaction wherePostId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reaction whereReactionId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reaction whereType( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reaction whereUpdatedAt( $value )
 * @mixin \Eloquent
 */
class Reaction extends Model {
	protected $table = 'reactions';
	public $timestamps = true;
	protected $primaryKey = 'reaction_id';
	public $incrementing = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = Reaction::select;
	/**
	 * The attributes that should be validated and their respective format
	 */
	const validation = [
		'reaction_id' => 'required|unique:reactions|numeric',
		'post_id' => 'numeric',
		'comment_id' => 'numeric',
		'author_id' => 'required|numeric',
		'type' => 'required|string'
	];
	const select = [
		'reaction_id',
		'post_id',
		'comment_id',
		'author_id',
		'type',
	];
	const select_more = [
		'created_at',
		'updated_at'
	];

	public function newEloquentBuilder( $query ) {
		return parent::newEloquentBuilder( $query )
			->join( 'users AS authors', 'reactions.author_id', '=', 'authors.user_id' );
	}

	public function post() {
		return $this->belongsTo('\App\Post', 'post_id');
	}

	public function comment() {
		return $this->belongsTo( '\App\Comment', 'comment_id' );
	}

	public function author() {
		return $this->belongsTo( '\App\User', 'author_id' );
	}
}