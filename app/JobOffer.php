<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobOffer extends Model 
{

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

    public function getAuthor()
    {
        return $this->belongsTo('User', 'author_id');
    }

    public function getEntity()
    {
        return $this->belongsTo('Entity', 'entity_id');
    }

}