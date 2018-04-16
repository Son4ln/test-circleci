<?php
namespace App\Repositories;

use App\Repositories\Interfaces\CreativeRoomRepositoryInterface;
use App\CreativeRoom;
use Auth;

/**
 * Class ContactRepository
 */
class CreativeRoomRepository extends Repository implements CreativeRoomRepositoryInterface
{
    /**
     * Model class name.
     *
     * @return string
     */
    public function modelName(): string
    {
        return CreativeRoom::class;
    }

    /**
     * Get all rooms user join as member
     */
    public function joinedRooms($select = ['*'])
    {
        return $this->model->select($select)->with('owner:id,name,photo,background,photo_thumbnail,background_thumbnail')
            ->withCount(['creativeroomUsers' => function($q) {
                $q->where('state', 1);
            }])->whereHas('creativeroomUsers', function($query) {
                $query->where('user_id', Auth::user()->id)
                    ->where('state', 1);
            })->orWhere('user_id', auth()->id());
           
    }
}
