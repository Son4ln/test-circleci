<?php
namespace App\Repositories;

use App\User;
use DB;

/**
 * Class UserRepository
 */
class UserRepository extends Repository
{
    const IS_CREATOR = 1;

    /**
     * @var array
     */
    protected $kind = [
        1 => ['creator', 'cert-creator'],
        2 => ['client', 'c-operation-client'],
        3 => 'admin'
    ];

    /**
     * Model class name.
     *
     * @return string
     */
    public function modelName(): string
    {
        return User::class;
    }

    /**
     * Get creators and filter it
     *
     * @param array $columns
     * @param array $filter
     * @return Model
     */
    public function getCreators($columns = ['*'], $filter = [])
    {
        $model = $this->model;

        if (isset($filter['name']) && $filter['name']) {
            $skills = config('const.skill');
            if(in_array( trim($filter['name']), $skills ) ){
                
                if( !isset( $filter['skill'] ) ){
                    array_push($filter, 'skill');
                }

                $key = array_search ($filter['name'], $skills);
                $filter['skill'][] = (int)$key;
                $filter['skill'] = array_unique($filter['skill']);
                $model->orWhere('name', 'LIKE', "%{$filter['name']}%");
                unset($filter['name']);
            }
        }

        if(isset($filter['skill']) && count($filter['skill']) > 0) {
            $flagSkill = true;
            $model = $model->whereHas('userSkills', function($query) use ($filter) {
                $query->whereIn('kind', $filter['skill']);
            });
        }

        $flagBase = false;
        if(isset($filter['base']) && is_numeric($filter['base'])) {
            $flagBase = true;
            $model = $model->where('base', $filter['base']);
        }

        if (isset($filter['name']) && $filter['name']) {

            $model = $model->where('name', 'LIKE', "%{$filter['name']}%")->orWhere('record', 'LIKE', "%{$filter['name']}%")->orWhere('career', 'LIKE', "%{$filter['name']}%");
           
            $bases = config('const.base');
            if( in_array(trim($filter['name']), $bases) ){
                $key = array_search ($filter['name'], $bases);
                $model = $model->orWhere('base', (int)$key);
            }

        }

        return $model->role('creator')->where('enabled', 1)->select($columns);
    }

    /**
     * Chat dialog
     *
     * @param int $userId
     * @return Collection
     */
    public function getPartnerByUserId($userId)
    {
        return DB::select("
          select user_id, name, (select count(*) from messages m where m.user_id = ? and m.send_user_id = a.user_id and kind = 1 and readed = 0) as unread
          from (
            select messages.user_id, (CASE WHEN users.nickname <> '' THEN users.nickname WHEN users.company <> '' THEN users.company ELSE users.name END) AS name
            from messages
            inner join users on messages.user_id = users.id
            where send_user_id = ?
            and messages.kind = 1
            union
            select messages.send_user_id, (CASE WHEN send.nickname <> '' THEN send.nickname WHEN send.company <> '' THEN send.company ELSE send.name END) AS name
            from messages
            inner join users as send on messages.send_user_id = send.id
            where user_id = ?
            and messages.kind = 1
        ) as a
        ", [$userId, $userId, $userId]);
    }

    /**
     * Get all users was activated
     *
     * @param array $columns
     * @return Collection
     */
    public function getActivatedUsers($columns = ['*'])
    {
        return $this->model->whereNotNull('activated_at')
            ->get($columns);
    }

    /**
     * Get users by filter
     *
     * @param array $filters
     * @return QueryBuilder
     */
    public function getAllUsers($filters)
    {
        $model = $this->model;

        if (isset($filters['kind']) && $filters['kind']) {
            $model = $model->role($this->kind[$filters['kind']]);
        }

        if (isset($filters['enabled'])) {
            $model = $model->where('enabled', $filters['enabled']);
        }

        if (isset($filters['enabled']) && $filters['enabled'] == 1) {
            $model = $model->whereNotNull('activated_at');
        }

        if (isset($filters['name']) && $filters['name']) {
            $model = $model->where(function($query) use ($filters) {
                $query->where('name', 'LIKE', "%{$filters['name']}%")
                    ->orWhere('email', 'LIKE', "%{$filters['name']}%");
            });
        }

        return $model;
    }

    public function activeCreator($id)
    {
        $user = $this->model->where('id', $id)->first();
        $user->update(['is_creator' => User::CREATOR_ACTIVATED]);
        return $user;
    }
}
