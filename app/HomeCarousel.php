<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomeCarousel extends Model
{
    protected $table = 'home_carousel';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'media', 'media_mobile', 'url'
    ];
}
