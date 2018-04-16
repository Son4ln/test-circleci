<?php
namespace App\Repositories;

use App\Repositories\Interfaces\FileRepositoryInterface;
use App\ProjectFile;
/**
 * Class ContactRepository
 */
class FileRepository extends Repository implements FileRepositoryInterface
{
    /**
     * Model class name.
     *
     * @return string
     */
    public function modelName(): string
    {
        return ProjectFile::class;
    }
}
