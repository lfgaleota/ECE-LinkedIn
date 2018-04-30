<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model 
{

    protected $table = 'events';
    public $timestamps = true;

    protected $primaryKey = 'event_id';
    protected $incrementing = false;

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