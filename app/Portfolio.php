<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;
use Auth;

class Portfolio extends Model {
    use SoftDeletes;

    const PUBLIC_SCOPE = 0;
    const CLIENT_SCOPE = 1;
    const MEMBER_SCOPE = 2;

    //
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'admin_updated' => 'boolean',
    ];

    /**
     * Get the thumb portfolio.
     *
     * @return string
     */
    public function getThumbAttribute()
    {
        if($this->attributes['thumb_path'] == '') {
            return 'public/images/video.png';
        } else {
            return $this->attributes['thumb_path'];
//            return Storage::disk('s3')->url($this->attributes['thumb_path']);
        }
    }

    /**
     * Get the video path.
     *
     * @param  string  $value
     * @return string
     */
    public function getVideoAttribute($value)
    {
//        return Storage::disk('s3')->url($this->attributes['url']);
        return $this->attributes['url'];
    }

    /**
     * Get all of the skills for the portfolio.
     */
    public function skills() {
        return $this->hasMany('App\PortfolioSkill', 'id');
    }

    /**
     * Get all of the skills for the portfolio.
     */
    public function types() {
        return $this->belongsToMany('App\Type', 'portfolio_types');
    }

    /**
     * Get all of the skills for the portfolio.
     */
    public function styles() {
        return $this->belongsToMany('App\Style', 'portfolio_styles');
    }

    public function pivotTypes() {
        return $this->hasMany('App\PortfolioType');
    }

    public function pivotStyles() {
        return $this->hasMany('App\PortfolioStyle');
    }

    /**
     * Get all of the user that own the portfolio.
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Get all of the user that own the portfolio.
     */
    public function portfolioTypes()
    {
        return $this->hasMany('App\PortfolioType', 'portfolio_id');
    }

    /**
     * Scope a query to only include role.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeListByRole($query)
    {
        if (Auth::user() && Auth::user()->isAdmin()) {
            return;
        }

        if (Auth::user() && Auth::user()->isClient()) {
            return $query->whereIn('scope', [
                self::PUBLIC_SCOPE,
                self::CLIENT_SCOPE,
            ]);
        }

        if (Auth::user() && Auth::user()->isCreator()) {
            return $query->whereIn('scope', [
                self::PUBLIC_SCOPE,
                self::CLIENT_SCOPE,
            ]);
        }

//        return $query->whereIn('scope', [
 ///           9999,
//        ]);
        return $query->whereIn('scope', [
            self::PUBLIC_SCOPE,
        ]);
    }

    /**
     * @return string
     */
    public function getVideoUrlAttribute()
    {
        if (!empty($this->attributes['url'])) {
//            return Storage::disk('s3')->url($this->attributes['url']);
            return $this->attributes['url'];
        }
        return url('/images/user.png');
    }

    /**
     * @return string
     */
    public function getThumbUrlAttribute()
    {
        if (!empty($this->attributes['thumb_path'])) {
//            return Storage::disk('s3')->url($this->attributes['thumb_path']);
            return $this->attributes['thumb_path'];
        }
        return url('/images/user.png');
    }

    /**
     * Check portfolio mime type
     */
    public function isVideo(){
        if (strpos($this->attributes['mime'], 'video') !== false) {
            return true;
        }
        return false;
    }

    /**
     * Check scope is public
     */
    public function isPublicScope()
    {
        return $this->attributes['scope'] == self::PUBLIC_SCOPE;
    }

    /**
     * Check scope is client
     */
    public function isClientScope()
    {
        return $this->attributes['scope'] == self::CLIENT_SCOPE;
    }

    /**
     * Check scope is member
     */
    public function isMemberScope()
    {
        return $this->attributes['scope'] == self::MEMBER_SCOPE;
    }

    /**
     * Get display portfolio name
     *
     * @return string
     */
    public function getDisplayNameAttribute()
    {
        return str_limit($this->attributes['title']);
    }
}
