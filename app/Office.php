<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'address', 'phone', 'lat', 'lng', 'type', 'email', 'image'
    ];

    protected $visible = ['id', 'name', 'address', 'phone', 'email', 'lat', 'lng', 'image'];
}
