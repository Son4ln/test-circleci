<?php
namespace App\Repositories;

use App\CreativeroomPreview;
/**
 * Class ContactRepository
 */
class CreativeroomPreviewRepository extends Repository
{
    /**
     * Model class name.
     *
     * @return string
     */
    public function modelName(): string
    {
        return CreativeroomPreview::class;
    }
}
