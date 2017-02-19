<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collection extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    public function results()
    {
        return $this->hasMany('App\Result', 'collection_id', 'id');
    }
}
