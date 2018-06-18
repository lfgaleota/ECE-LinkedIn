<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * App\Entity
 *
 * @property int $entity_id
 * @property int $author_id
 * @property string $name
 * @property string|null $location
 * @property string|null $photo_url
 * @property string|null $description
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity whereAuthorId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity whereDescription( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity whereEntityId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity whereLocation( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity whereName( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity wherePhotoUrl( $value )
 * @mixin \Eloquent
 */
class Entity extends Model {
	protected $table = 'entities';
	public $timestamps = false;
	protected $primaryKey = 'entity_id';
	public $incrementing = true;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'author_id',
		'name',
		'location',
		'photo_url',
		'description',
	];

	const validation_create = [
		'name' => 'required|string',
		'location' => 'required|string',
		'description' => 'required|string',
		'photo' => 'required|mimes:jpeg,png'
	];

	const validation_update = [
		'name' => 'string',
		'location' => 'string',
		'description' => 'string',
		'photo' => 'mimes:jpeg,png'
	];

	const searchable_fields = [ 'name', 'location', 'description', 'photo_url' ];

	const default_photo_url = '/images/avatar.png';

	public function author() {
		return $this->belongsTo( '\App\User', 'author_id' );
	}

	public function setPhoto( $file ) {
		$this->photo_url = \App\Utils::getFileUrl( Utils::store( Auth::user(), $file, 'images' ) );
	}
}