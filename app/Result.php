<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Result extends Model
{
    use SoftDeletes;

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

    protected $hidden = [
        'deleted_at',
    ];

    public function collection()
    {
        return $this->hasOne('App\Collection', 'id');
    }

    public function getImageAttribute()
    {
        return urldecode($this->attributes['image']);
    }

    public function getUrlAttribute()
    {
        return urldecode($this->attributes['url']);
    }
}
