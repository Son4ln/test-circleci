<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreativeRoom extends Model
{
    use SoftDeletes;
    
    const NORMAL_MESSAGE_TYPE = 1;
    const CRLUO_MESSAGE_TYPE  = 2;
    const PROJECT_FILE_TYPE   = 1;
    const PREVIEW_FILE_TYPE   = 2;
    const DELIVER_FILE_TYPE   = 3;

    /**
     * @var array
     */
    public $labels = [
        0 => 'status-success',
        1 => 'status-danger'
    ];

    /**
     * @var string
     */
    protected $table = 'creative_rooms';

    /**
     * @var string
     */
    protected $fillable = ['title', 'user_id', 'project_id', 'desc', 'invitation_token', 'label', 'thumbnail'];

    /**
     * Get the CreativeroomMessage record associated with the Creativeroom.
     */
    public function messages()
    {
        return $this->hasMany('App\CreativeroomMessage', 'creativeroom_id');
    }

    /**
     * Get the File record associated with the Creativeroom.
     */
    public function files()
    {
        return $this->hasMany('App\ProjectFile', 'creativeroom_id');
    }

    /**
     * Get association with proposals table
     */
    public function proposal()
    {
        return $this->hasOne('App\Proposal', 'room_id');
    }

    /**
     * Get the Project record associated with the CreativeroomMessage.
     */
    public function projectFiles()
    {
        return $this->hasMany(ProjectFile::class, 'creativeroom_id')
            ->where('kind', ProjectFile::PROJECT_FILE);
    }

    /**
     * Get the Project record associated with the CreativeroomMessage.
     */
    public function previewFiles()
    {
        return $this->hasMany(ProjectFile::class, 'creativeroom_id')
            ->where('kind', ProjectFile::PREVIEW_FILE);
    }

    /**
     * Get the Project record associated with the CreativeroomMessage.
     */
    public function deliverFiles()
    {
        return $this->hasMany(ProjectFile::class, 'creativeroom_id')
            ->where('kind', ProjectFile::DELIVER_FILE);
    }

    /**
     * Get the Project record associated with the CreativeroomMessage.
     */
    public function creativeroomUsers()
    {
        return $this->hasMany('App\CreativeroomUser', 'creativeroom_id');
    }

    /**
     * Get the Project record associated with the Creativeroom.
     */
    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    /**
     * Get owner
     */
    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Get relation with creativeroom user
     */
    public function roomUsers()
    {
        return $this->belongsToMany('App\User', 'creativeroom_users', 'creativeroom_id', 'user_id');
    }

    /**
     * Get thumbnail
     */
    public function getDisplayThumbnailAttribute()
    {
        if ($this->thumbnail) {
            if (!strpos($this->thumbnail, 'thumbnail')) {
                return \Storage::disk('s3')->url($this->thumbnail);
            }

            return $this->thumbnail;
        }

        return $this->owner->backgroundUrl;
    }

    /**
     * Check user is manager
     */
    public function isManager()
    {
        return Auth::user()->id == $this->user_id;
    }

    /**
     * Check current user exists in room
     */
    public function isUserActive()
    {
        return $this->creativeroomUsers()
            ->where(['user_id' => Auth::id(), 'state' => 1])->exists();
    }

    /**
     * Get label by statuses
     */
    public function getLabel()
    {
        return $this->labels[$this->label];
    }

    /**
     * Check room label
     */
    public function isFinish()
    {
        return $this->label == 1;
    }
}
