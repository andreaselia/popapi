<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'collection_id',
        'name',
        'slug',
        'sku',
        'image',
        'url',
    ];

    public function collection()
    {
        return $this->hasOne('App\Collection', 'id');
    }
}
