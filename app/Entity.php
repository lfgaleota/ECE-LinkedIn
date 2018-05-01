<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity
 *
 * @property int $entity_id
 * @property int $author_id
 * @property string $name
 * @property string|null $location
 * @property string|null $photo_url
 * @property string|null $description
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity whereEntityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity wherePhotoUrl($value)
 * @mixin \Eloquent
 */
class Entity extends Model 
{

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

    public function getAuthor()
    {
        return $this->belongsTo('User', 'author_id');
    }

}