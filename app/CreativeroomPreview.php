<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreativeroomPreview extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'creativeroom_id',
        'kind',
        'user_id',
        'title',
        'file_id',
        'start',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'title' => 'json'
    ];

    /**
     * Get assciation with user
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
