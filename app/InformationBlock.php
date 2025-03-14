<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InformationBlock extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['source_id', 'image', 'data', 'source', 'template'];
    protected $visible = ['id', 'image', 'data', 'template'];

    public static function for_source($source, $source_id = NULL) {
        return InformationBlock::whereSource($source)->whereSourceId($source_id)->orderBy('id')->get();
    }
}
