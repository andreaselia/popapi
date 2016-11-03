<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = [
        'slug',
        'name'
    ];

    public function results()
    {
        return $this->hasMany('App\Result', 'collection_id', 'id');
    }
}
