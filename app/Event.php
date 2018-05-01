<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Event
 *
 * @property int $event_id
 * @property int $author_id
 * @property string $date
 * @property string $name
 * @property string|null $description
 * @property string $location
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Event extends Model 
{

    protected $table = 'events';
    public $timestamps = true;

    protected $primaryKey = 'event_id';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id',
        'author_id',
        'date',
        'name',
        'description',
        'location',
    ];

    public function getAuthor()
    {
        return $this->belongsTo('User', 'author_id');
    }

}