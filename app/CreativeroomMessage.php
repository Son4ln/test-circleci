<?php

namespace App;

use Storage;
use Illuminate\Database\Eloquent\Model;

class CreativeroomMessage extends Model
{
    /**
     * @var string
     */
    protected $table = 'creativeroom_messages';

    /**
     * @var array
     */
    protected $fillable = [
        'creativeroom_id',
        'title',
        'user_id',
        'reader',
        'kind',
        'message',
        'files',
        'recipient_id',
        'is_public'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function getFilesAttribute($value)
    {
        return json_decode($value, true);
    }

    /**
     * Get associated with users table
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the CreativeRoom record associated with the CreativeroomMessage.
     */
    public function creativeRoom()
    {
        return $this->belongsTo('App\CreativeRoom', 'creativeroom_id');
    }
    //
    // /**
    //  * Get avatar path
    //  */
    // public function getUserInfoAttribute()
    // {
    //     $user = $this->user()->first(['id', 'photo', 'name']);
    //     $user->photo = Storage::disk('s3')->url($user->photo);
    //     return $user;
    // }
}
