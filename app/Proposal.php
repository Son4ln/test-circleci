<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Proposal extends Model
{
    const PENDING_STATE = 50;
    
    /**
     * @var array
     */
    protected $fillable = ['project_id', 'user_id', 'text', 'price', 'price2',
        'price3', 'attachments', 'offer', 'room_id', 'state'];

    /**
     * @var array
     */
    protected $casts = [
        'attachments' => 'json'
    ];

    /**
     * Get label
     */
    public $labels = [
        0  => '',
        40 => 'label-info',
        50 => 'label-primary',
        60 => 'label-success',
        70 => 'label-danger'
    ];

    /**
     * @var array
     */
    public $states = [
        'started'    => 40,
        'pending'    => 50,
        'checking'   => 60,
        'delivered'  => 70,
    ];

    /**
     * Get association with users table
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get association with projects table
     */
    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    /**
     * Get association with room
     */
    public function room() {
        return $this->belongsTo('App\CreativeRoom', 'room_id');
    }

    /**
     * Scope a query to only include current users proposals.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOwn($query)
    {
        return $query->where('user_id', Auth::user()->id);
    }

    public function getLabelAttribute()
    {
        return $this->labels[$this->state];
    }

    public function projectIsNotStarted(){
        $project = new \App\Project;
        return $this->project_status < $project->statuses['started'];
    }
}
