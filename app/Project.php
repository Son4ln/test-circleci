<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Traits\Changeable;
use Storage;

/**
 * Class Project
 *
 * @method Builder owner()
 * @method Builder prime()
 * @method Builder nonPrime()
 */
class Project extends Model
{
    use Changeable;

    const PROJECT_CLOSE_STATUS = 999;
    const STARTED_STATUS = 40;
    const PUBLIC_STATUS = 30;

    /**
     * @var array
     */
    public $statuses = [
        'draft'      => 0,
        'registered' => 10,
        'paid'       => 20,
        'public'     => 30,
        'cancel'     => 999,
        'started'    => 40,
        'pending'    => 50,
        'checking'   => 60,
        'delivered'  => 70,
    ];

    /**
     * @var string
     */
    protected $table = 'projects';

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
    protected $casts = [
        'real_or_anime'  => 'array',
        'type_of_movie'  => 'array',
        'client_arrange' => 'array',
        'part_of_work'   => 'array',
        'attachments'    => 'array',
        'info_files'     => 'array',
        'standard_files' => 'array'
    ];

    protected $dates = [
        'duedate_at',
        'created_at',
        'updated_at',
        'deleted_at',
        'delivered_at',
        'finished_at',
        'expired_at'
    ];

    protected $labels = [
        0   => 'label-default',
        10  => 'label-warning',
        20  => 'label-info',
        30  => 'label-primary',
        999 => 'label-default',
        40  => 'label-success',
        50  => 'label-pink',
        60  => 'label-danger',
        70  => 'label-danger'
    ];

    protected $messages = [
        0   => '仕事の依頼をご登録ありがとうございます。本プロジェクトは仮登録中のため、デポジット（預り金）をお支払する事により完了します。クレジットカード情報をご入力の上、お支払いください。',
        10  => '仕事の依頼をご登録ありがとうございます。本プロジェクトは仮登録中のため、デポジット（預り金）をお支払する事により完了します。クレジットカード情報をご入力の上、お支払いください。',
        20  => 'デポジット（預り金）のお支払いありがとうございます。運営者で最終確認を行いますので、公開までしばらくお待ちください',
        30  => '公開 仕事が公開されました。',
        999 => '',
        40  => '案件がスタートしました。C-Base Projectにて、クリエイターとやり取りし、制作を進めてください。',
        50  => '',
        60  => ''
    ];

    /**
     * Get the ProjectFiles record associated with the Project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projectFiles()
    {
        return $this->hasMany('App\ProjectFile');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get display image
     */
    public function getDisplayImageAttribute()
    {
        if ($this->attributes['image']) {
            return Storage::disk('s3')->url($this->attributes['image']);
        } else {
            return $this->user->background_url;
        }
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeOwner(Builder $query)
    {
        return $query->with('user:id,background,photo')->where('user_id', Auth::id());
    }

    /**
     * @param Builder $query
     * @return $this
     */
    public function scopePrime(Builder $query)
    {
        return $query->where('is_prime', 1);
    }

    /**
     * @param Builder $query
     * @return $this
     */
    public function scopeNonPrime(Builder $query)
    {
        // where(status=50) for preview( must not viewed)
        return $query->where('is_prime', 0)
            ->where('status', '<>', $this->statuses['cancel'])
            ->where(function($scope) {
                $scope->where('status', $this->statuses['public'])
                    ->orWhereIn('id', function($subquery) {
                        $subquery->select('project_id')
                            ->distinct()
                            ->from('proposals')
                            ->whereNotNull('offer')
                            ->where('user_id', auth()->id());
                        });
            });
    }

    /**
     * @param Builder $query
     * @return mixed
     */
    public function scopeSearchProject($query)
    {
        return $query
        ->join('users','users.id','projects.user_id')
        ->select(
            'projects.id', 'projects.title', 'projects.duedate_at', 'projects.price_max', 'projects.price_min',
            'projects.user_id', 'projects.image', 'projects.status', 'projects.created_at', 'projects.updated_at',
            'users.background as user_background','projects.is_price_undecided','projects.price_min','projects.price_max','projects.duedate_at','projects.expired_at',
            DB::raw("(CASE WHEN projects.status = {$this->statuses['public']} THEN 0 ELSE 1 END) AS sort")
        )->where('projects.status', '>=', $this->statuses['public'])
        ->where('projects.status', '<>', $this->statuses['cancel'])
        ->orderBy('sort', 'ASC')
        ->orderBy('projects.id', 'DESC');
    }

    /**
     * @param Builder $query
     * @return mixed
     */
    public function scopeClient($query)
    {
        return $query->join('users', 'users.id', '=', 'projects.user_id')
            ->select(['users.*',
                DB::raw(" (CASE WHEN users.nickname <> '' THEN users.nickname ELSE users.name END) AS name")])
            ->pluck('name', 'users.id')//->lists('name', 'users.id')
            ;
    }

    /**
     * @param Builder $query
     * @param int $id
     * @return mixed
     */
    public function scopeFromCompeID($query, $id)
    {
        return $query->whereIn('id', function ($in) use ($id) {
            $in->select('project_id')
                ->from('compes')
                ->where('id', $id);
        })->first();
    }

    /**
     * Get offered proposal
     */
    public function offeredProposal()
    {
        return $this->proposals()->where('offer', 1)->first();
    }

    /**
     * Get relation with proposals table
     */
    public function proposals()
    {
        return $this->hasMany('App\Proposal');
    }

    /**
     * Get selected proposals
     */
    public function selectedProposals()
    {
        return $this->proposals()->where('state', '<>', 0);
    }

    /**
     * Get operation proposal
     */
    public function operationCreatorProposal()
    {
        return $this->proposals()->where('state', 40)
           ->where('user_id', auth()->id())->first();
    }

    /**
     * Get room
     */
    public function firstRoom()
    {
        $this->hasOne('App\CreativeRoom');
    }

    /**
     * Get display label by status
     */
    public function getStatusLabelAttribute()
    {
        /**
         * @var int
         */
        $status = $this->attributes['status'];
        return isset($this->labels[$status]) ? $this->labels[$status] : '';
    }

    /**
     * Get project status
     *
     * @return bool
     */
    public function isClose()
    {
        return $this->attributes['status'] == self::PROJECT_CLOSE_STATUS;
    }

    /**
     * Check project status
     */
    public function isPublic()
    {
        return $this->attributes['status'] == $this->statuses['public'];
    }

    /**
     * Project started
     *
     * @return bool
     */
    public function isStarted()
    {
        return $this->attributes['status'] == $this->statuses['started'];
    }

    /**
     * Project delivery
     */
    public function isDelivered()
    {
        return $this->attributes['status'] == $this->statuses['delivered'];
    }

    /**
     * Check project is own
     *
     * @return bool
     */
    public function isOwn()
    {
        return $this->attributes['user_id'] == Auth::user()->id;
    }

    public function isNotStarted()
    {
        return $this->attributes['status'] < $this->statuses['started'];
    }

    /**
     * User can choose proposal
     *
     * @return bool
     */
    public function canChoosePropose()
    {
        /**
         * @var bool
         */
        $isProposalLimit = $this->proposals()->where('kind', 1)->count() >= 3;

        return !$this->isClose() && $this->isOwn() && !$isProposalLimit;
    }

    /**
     * Check user can select proposals
     *
     * @return bool
     */
    public function canSelect()
    {
        /**
         * @var int
         */
        $poroposalOffered = $this->proposals()
            ->where('offer', 1)->count();

        if (Auth::user()->hasRole('prime-client')) {
            return  $poroposalOffered < 6;
        }

        return $poroposalOffered < 1;
    }

    /**
     * Check user can cancel proposals
     *
     * @return bool
     */
    public function canCancel()
    {
        return $this->attributes['status'] < $this->statuses['paid'];
    }

    /**
     * Get max current max price in proposals
     *
     * @return int
     */
    public function maxPrice()
    {
        return $this->proposals()->max('price');
    }

    /**
     * Get two latest propose project
     */
    public function scopeLatestPropose($query)
    {
        $subQuery = DB::table('proposals')
            ->select('project_id', DB::raw('MAX(proposals.updated_at) as updated_at'))
            ->distinct('project_id')
            ->join('projects', 'proposals.project_id', '=', 'projects.id')
            ->groupBy('project_id')
            ->where('projects.user_id', Auth::id());

        return $query->select('id', 'title', 'duedate_at', 'price_max', 'price_min', 'projects.user_id', 'image')
            ->where('status', '<', $this->statuses['pending'])
            ->whereIn('id', function($query) use ($subQuery) {
                $query->select('project_id')
                    ->from(DB::raw('(' . $subQuery->toSql() . ') as sub_proposals'))
                    ->mergeBindings($subQuery)
                    ->orderBy('sub_proposals.updated_at', 'DESC')
                    ->take(2);
            });
    }

    /**
     * Get project messages
     *
     * @return int
     */
    public function getMessage()
    {
        return $this->messages[$this->attributes['status']] ?? '';
    }

    /**
     * @return int (JPY)
     */
    public function getFeesAttribute()
    {
        return $this->is_certcreator ? config('const.project_fees.certcreator') : config('const.project_fees.normal');
    }

    /**
     * @return int (JPY)
     */
    public function getOperationFeesAttribute()
    {
        return config('const.project_fees.prime');
    }

    /**
     * Change project status
     *
     * @param string $status
     * @return Model
     */
    public function changeStatus(string $status)
    {
        $this->fill([
            'status' => $this->statuses[$status]
        ]);

        return $this->save();
    }

    /**
     * Check status
     *
     * @param string $statusText
     * @return bool
     */
    public function isStatus($statusText)
    {
        if (array_key_exists($statusText, $this->statuses)) {
            return $this->status == $this->statuses[$statusText];
        }

        return false;
    }

    /**
     * Check project is Prime
     *
     * @return bool
     */
    public function isPrime(){
        return $this->is_prime == 1;
    }
}
