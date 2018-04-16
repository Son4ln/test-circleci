<?php

namespace App;

use App\Mail\ResetPassword;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Laravel\Cashier\Billable;
use Spatie\Permission\Traits\HasRoles;
use Carbon\Carbon;

/**
 * Class User
 *
 * @package App
 * @property int $id
 * @property bool $is_admin
 * @property bool $is_client
 * @property bool $is_adclient
 * @property bool $is_creator
 * @property bool $is_certcreator
 */
class User extends Authenticatable
{
    use Billable;
    use Notifiable;
    use SoftDeletes;
    use HasRoles;

    const CREATOR_REGISTING = 1;
    const CREATOR_ACTIVATED = 2;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //protected $fillable = [
    //    'name', 'email', 'password',
    //];
    protected $guarded = ['id'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'knew' => 'array',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'activated_at'
    ];

    /**
     * Get relation with projects table
     */
    public function projects()
    {
        return $this->hasMany('App\Project');
    }

    /**
     * Get relation with proposals table
     */
    public function proposals()
    {
        return $this->hasManyThrough('App\Proposal', 'App\Project');
    }

    /**
     * Get association with portfolios table
     */
    public function portfolios()
    {
        return $this->hasMany('App\Portfolio');
    }

    public function scopeFromProjectMember($query, $id)
    {
        return $query->whereIn('id', function($in) use ($id){
                    $in->select('user_id')
                    ->from('project_members')
                    ->where('id', $id);
                })->get();
    }

    /**
     * @param Builder $query
     * @param array   $skills
     * @return Builder
     */
    public function scopeSkill($query, $skills)
    {
        return $query->whereIn('id', function ($in) use ($skills) {
            $in->select('id')
                ->from('user_skills')
                ->whereIn('kind', $skills);
        });
    }

    public function roomUsers()
    {
        return $this->hasMany('App\CreativeroomUser');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeCreator($query)
    {
        return $this->role('creator')->where('enabled', 1)->where( 'is_creator', User::CREATOR_ACTIVATED);
    }

    /**
     * @return bool
     */
    public function isActivated()
    {
        return $this->activated_at === null;
    }

    /**
     * @return bool
     * @deprecated 1.0.0 Please using $user->hasRole() instead
     */
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    /**
     * @return bool
     * @deprecated 1.0.0 Please using $user->hasRole() instead
     */
    public function isCreator()
    {
        return $this->hasAnyRole(['creator', 'cert-creator']) && $this->isEnabled();
    }

    /**
     * @return bool
     * @deprecated 1.0.0 Please using $user->hasRole() instead
     */
    public function isCertCreator()
    {
        return $this->hasRole('creator');
    }

    /**
     * @return bool
     * @deprecated 1.0.0 Please using $user->hasRole() instead
     */
    public function isClient()
    {
        return $this->hasAnyRole(['client', 'c-operation-client']);
    }

    /**
     * @return bool
     * @deprecated 1.0.0 Please using $user->hasRole() instead
     */
    public function isAdClient()
    {
        return $this->hasRole('c-operation-client');
    }

    /**
     * Check creator is activated
     */
    public function isActivatedCreator()
    {
        return $this->isCreator() && $this->attributes['is_creator'] == self::CREATOR_ACTIVATED;
    }

    /**
     * Check creator is not activated
     */
    public function isNotActivatedCreator()
    {
        return $this->isCreator() && $this->attributes['is_creator'] != self::CREATOR_ACTIVATED;
    }

    /**
      * is enabled
      */
    public function isEnabled()
    {
        return $this->attributes['enabled'] == 1;
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trackingJobs()
    {
        return $this->hasMany(TrackingJob::class, 'user_id', 'id');
    }

    /**
     * @return string
     */
    public function getPhotoUrlAttribute()
    {
        if (strpos($this->attributes['photo'], 'http') !== false) {
            return $this->attributes['photo'];
        }

        if (!empty($this->attributes['photo'])) {
            return Storage::disk('s3')->url(ltrim($this->attributes['photo'], "/"));
        }

        return url('/images/user.png');
    }

    /**
     * @return string
     */
    public function getPhotoThumbnailUrlAttribute()
    {
        if (strpos($this->attributes['photo_thumbnail'], 'http') !== false) {
            return $this->attributes['photo_thumbnail'];
        }

        if (!empty($this->attributes['photo_thumbnail'])) {
            return Storage::disk('s3')->url(ltrim($this->attributes['photo_thumbnail'], "/"));
        }

        return $this->getPhotoUrlAttribute();
    }

    /**
     * @return string|null
     */
    public function getBackgroundUrlAttribute()
    {
        if (!empty($this->attributes['background'])) {
            return Storage::disk('s3')->url(ltrim($this->attributes['background'], "/"));
        }

        return null;
    }

    /**
     * @return string|null
     */
    public function getBackgroundThumbnailUrlAttribute()
    {
        if (!empty($this->attributes['background_thumbnail'])) {
            return Storage::disk('s3')->url(ltrim($this->attributes['background_thumbnail'], "/"));
        }

        return $this->getBackgroundUrlAttribute();
    }

    /**
     * Get skills for user
     */
    public function userSkills() {
        return $this->hasMany('App\UserSkill', 'id');
    }

    /**
     * Get softwears for user
     */
    public function softwears() {
        return $this->hasMany('App\UserSoftwear', 'id');
    }

    /**
     * Remove a global scope on the model.
     *
     * @param  \Illuminate\Database\Eloquent\Scope|\Closure|string  $scope
     */
    public static function removeGlobalScope($scope)
    {
        if (is_string($scope)) {
            unset(static::$globalScopes[static::class][$scope]);
        } elseif ($scope instanceof Closure) {
            unset(static::$globalScopes[static::class][spl_object_hash($scope)]);
        } elseif ($scope instanceof Scope) {
            unset(static::$globalScopes[static::class][get_class($scope)]);
        }
    }

    /**
     * Get the user's birth.
     *
     * @return string
     */
    public function getBirthAttribute()
    {
        return Carbon::parse($this->attributes['birth'])->format('Y/m/d');
    }

    /**
     * Get display name
     *
     * @return string
     */
    public function getDisplayNameAttribute()
    {
        return str_limit($this->attributes['name'], 14);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        Mail::to($this)
            ->send(new ResetPassword($this, $token));
    }

    /**
     * Determine whether user can join room
     */
    public function canJoinRoom($roomId)
    {
        $id = $this->id;
        $usersCount = $this->roomUsers()->where([
            'creativeroom_id' => $roomId,
            'user_id'   => $id
        ])->count();

        return (bool) $usersCount || $this->hasRole('admin');
    }
}
