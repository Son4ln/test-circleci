<?php
namespace App\Repositories;

use App\Document;
/**
 * Class ContactRepository
 */
class DocumentRepository extends Repository
{
    /**
     * Model class name.
     *
     * @return string
     */
    public function modelName(): string
    {
        return Document::class;
    }

    public function getDocumentsByFilters($filters)
    {
        $model = $this->model;

        if(isset($filters['genre']) && is_array($filters['genre'])) {
            $model = $model->whereIn('genre', $filters['genre']);
        }

        if($filters['order']) {
            $model = $model->orderBy($filters['order']);
        }

        return $model;
    }
}
