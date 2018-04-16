<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     * @var string
     */
    protected $table = 'payments';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var array
     */
    protected $dates = ['paid_at', 'created_at', 'updated_at'];

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUser(Builder $query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Get assciate with project
     */
    public function project()
    {
        return $this->belongsTo('App\Project');
    }
}
