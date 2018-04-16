<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TrackingJob
 *
 * @package App
 * @property int $id
 * @property int $user_id
 * @property User $user
 * @property string $ad_account_id
 * @property string $campaign_id
 * @property int $condition_type
 * @property float $condition_value
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */
class TrackingJob extends Model
{
    const CONDITION_SPEND_GTE = 1;
    const CONDITION_PERCENT_CLICK_LTE = 2;

    /**
     * @var string
     */
    protected $table = "tracking_jobs";

    /**
     * @var string
     */
    protected $primaryKey = "id";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ad_account_id', 'campaign_id', 'condition_type', 'condition_value'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return string
     */
    public function getConditionTextAttribute()
    {
        $conditionTypes = static::getConditionTypes();

        return $conditionTypes[$this->attributes['condition_type']] . ' ' . $this->attributes['condition_value'];
    }

    /**
     * @return array
     */
    public static function getConditionTypes()
    {
        return [
            static::CONDITION_SPEND_GTE => 'Spend greater than or equal',
            static::CONDITION_PERCENT_CLICK_LTE => 'Percent of clicks less than or equal',
        ];
    }
}
