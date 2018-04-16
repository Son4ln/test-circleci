<?php
namespace App\Repositories;

use App\Info;
use Auth;

/**
 * Class ContactRepository
 */
class NotificationRepository extends Repository
{
    const CREATOR_NOTIFICATION_TYPE = 1;
    const CLIENT_NOTIFICATION_TYPE  = 2;
    const MEMBER_NOTIFICATION_TYPE  = 3;

    /**
     * Model class name.
     *
     * @return string
     */
    public function modelName(): string
    {
        return Info::class;
    }

    /**
     * Get all creator notifications
     */
    public function getCreatorNotifications($columns = ['*'])
    {
        return $this->model->where('kind', self::CREATOR_NOTIFICATION_TYPE)
            ->orderBy('created_at', 'DESC')->get($columns);
    }

    /**
     * Get all client notifications
     */
    public function getClientNotifications($columns = ['*'])
    {
        return $this->model->where('kind', self::CLIENT_NOTIFICATION_TYPE)
            ->orderBy('created_at', 'DESC')->get($columns);
    }

    /**
     * Get all member notifications
     */
    public function getMemberNotifications($columns = ['*'])
    {
        return $this->model->where('kind', self::MEMBER_NOTIFICATION_TYPE)
            ->orderBy('created_at', 'DESC')->get($columns);
    }

    /**
     * Get current notification
     */
    public function getUserNotifications($columns = ['*'])
    {
        $model = $this->model->where('kind', self::MEMBER_NOTIFICATION_TYPE);

        if (Auth::user()->isCreator()) {
            $model = $model->orWhere('kind', self::CREATOR_NOTIFICATION_TYPE);
        }

        if (Auth::user()->isClient()) {
            $model = $model->orWhere('kind', self::CLIENT_NOTIFICATION_TYPE);
        }

        //OLD
        //return $model->latest()->get($columns = ['*']);
        //New
        return $model->latest()->get($columns);
    }
}
