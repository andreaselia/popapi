<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    public function results()
    {
        return $this->hasMany('App\Result', 'collection_id', 'id');
    }
}
