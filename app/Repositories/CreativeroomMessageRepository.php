<?php
namespace App\Repositories;

use App\Repositories\Interfaces\CreativeroomMessageRepositoryInterface;
use App\CreativeroomMessage;
/**
 * Class ContactRepository
 */
class CreativeroomMessageRepository extends Repository implements CreativeroomMessageRepositoryInterface
{
    /**
     * CONST
     */
    const CREATOR_MESSAGE_TYPE = 2;
    const CLIENT_MESSAGE_TYPE  = 3;

    /**
     * Model class name.
     *
     * @return string
     */
    public function modelName(): string
    {
        return CreativeroomMessage::class;
    }

    public function getCreatorMessages($columns = ['*'])
    {
        return $this->model->where('kind', self::CREATOR_MESSAGE_TYPE)->get($columns);
    }

    public function getClientMessages($columns = ['*'])
    {
        return $this->model->where('kind', self::CLIENT_MESSAGE_TYPE)->get($columns);
    }
}
