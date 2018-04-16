<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreativeroomUser extends Model
{
    const MASTER_ROLE = 3;
    const MEMBER_ROLE = 1;

    /**
     * @var array
     */
    protected $fillable = ['creativeroom_id', 'user_id', 'role', 'state'];

    /**
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Get role text
     *
     * @param $value int
     * @return string
     */
    public function getRoleNameAttribute()
    {
        $roles = [
            self::MASTER_ROLE => 'マスター',
            self::MEMBER_ROLE => 'メンバー'
        ];

        if (isset($roles[$this->attributes['role']]))
            return $roles[$this->attributes['role']];
        else
            return 'No role!';
    }

    /**
     * Get associated with users table
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get associated with creative_rooms table
     */
    public function creativeRoom()
    {
        return $this->belongsTo('App\CreativeRoom', 'creativeroom_id');
    }

    /**
     * Check creative room user role
     */
    public function isMaster()
    {
        return $this->attributes['role'] == self::MASTER_ROLE;
    }

    /**
     * Get user state
     *
     * @return bool
     */
    public function isActive(){
        return $this->attributes['state'] == 1;
    }
}
