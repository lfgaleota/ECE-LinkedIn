<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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