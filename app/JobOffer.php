<?php

namespace App;

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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\JobOffer whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\JobOffer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\JobOffer whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\JobOffer whereEntityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\JobOffer whereJobId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\JobOffer wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\JobOffer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class JobOffer extends Model 
{
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

    public function getAuthor()
    {
        return $this->belongsTo('User', 'author_id');
    }
        public function getPosition()
    {
        return $this->position;
    }
            public function getDescription()
    {
        return $this->description;
    }



    public function getEntity()
    {
        return $this->belongsTo('Entity', 'entity_id');
    }

    public function setEntity($entity)
    {
        return $this->entity_id=$entity;
    }

             public function setPosition( $position)
    {
       return  $this->position=$position;
    }

         public function setDescritpion( $description)
    {
       return  $this->description=$description;
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
			$array[ $searchableField ] = $origArray[ $searchableField ];
		}

		return $array;
	}
}