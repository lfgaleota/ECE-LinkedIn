<?php

namespace App;

use App\Notifications\JobApplication;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

/**
 * App\JobOffer
 *
 * @property int $job_id
 * @property int $author_id
 * @property int $entity_id
 * @property string $position
 * @property string $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\JobOffer whereAuthorId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\JobOffer whereCreatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\JobOffer whereDescription( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\JobOffer whereEntityId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\JobOffer whereJobId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\JobOffer wherePosition( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\JobOffer whereUpdatedAt( $value )
 * @mixin \Eloquent
 */
class JobOffer extends Model {
	use Searchable;
	protected $table = 'job_offers';
	public $timestamps = true;
	protected $primaryKey = 'job_id';
	public $incrementing = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'job_id',
		'author_id',
		'entity_id',
		'position',
		'description',
	];
	const searchable_fields = [ 'job_id', 'position', 'description' ];

	const validation_create = [
		'entity_id' => 'required|numeric',
		'description' => 'required|string',
		'position' => 'required|string'
	];

	const validation_update = [
		'description' => 'string',
		'position' => 'string'
	];

	public function author() {
		return $this->belongsTo( '\App\User', 'author_id' );
	}

	public function entity() {
		return $this->belongsTo( '\App\Entity', 'entity_id' );
	}

	/**
	 * Get the indexable data array for the model.
	 *
	 * @return array
	 */
	public function toSearchableArray() {
		$origArray = $this->toArray();
		$array = [];

		foreach( JobOffer::searchable_fields as $searchableField ) {
			if( isset( $origArray[ $searchableField ] ) ) {
				$array[ $searchableField ] = $origArray[ $searchableField ];
			} else {
				$array[ $searchableField ] = null;
			}
		}

		$origEntity = $this->entity->toArray();

		foreach( Entity::searchable_fields as $searchableField ) {
			if( isset( $origEntity[ $searchableField ] ) ) {
				$array[ 'entity_' . $searchableField ] = $origEntity[ $searchableField ];
			} else {
				$array[ 'entity_' . $searchableField ] = null;
			}
		}

		return $array;
	}

	public function apply( User $user, $coverLetter ) {
		$this->author->notify( new JobApplication( $user, $this, $coverLetter ) );
	}
}