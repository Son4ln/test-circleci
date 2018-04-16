<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Document extends Model
{
    //
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    /**
     * Get s3 file path
     *
     * @return String
     */
    public function getUrlAttribute()
    {
        return Storage::disk('s3')->url($this->attributes['filename']);
    }
}
