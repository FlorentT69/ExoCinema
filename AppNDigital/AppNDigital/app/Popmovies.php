<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Popmovies extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_movie', 'nb_views','nb_likes'
    ];

}
