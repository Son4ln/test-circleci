<?php
namespace App\Repositories;

use App\Message;
/**
 * Class ContactRepository
 */
class MessageBoxRepository extends Repository
{
    /**
     * Model class name.
     *
     * @return string
     */
    public function modelName(): string
    {
        return Message::class;
    }

    /**
     * Change message state to readed
     *
     * @param int $userId
     * @return void
     */
    public function markReadedMessage($userId)
    {
        $this->model->receiveChat($userId)->update(['readed' => true]);
    }

    /**
     * Get all user messages
     *
     * @param int $userId
     * @return Collection
     */
    public function getMessagesByUserId($userId)
    {
        return $this->model->chat($userId);
    }

    /**
     * Filter message
     */
    public function getMessagesByFilter($filters)
    {
        $model = $this->model;

        // if($filters['kind']) {
        //     $model = $model->where('kind', $filter['kind']);
        // }
        if(is_numeric($filters['readed'])) {
            $model = $model->where('readed', $filters['readed']);
        }

        if($filters['send_user_id']) {
            $model = $model->where('send_user_id', $filters['send_user_id']);
        }

        if($filters['user_id']) {
            $model = $model->where('user_id', $filters['user_id']);
        }

        if($filters['title']) {
            $model = $model->where('title', 'like', "%{$filters['title']}%");
        }

        return $model;
    }

    /**
     * Get latest messages
     */
    public function latest()
    {
        return $this->model->latest();
    }
}
