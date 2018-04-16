<?php

namespace App\Contracts\Criteria;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use App\Contracts\Repository\RepositoryInterface;

interface CriteriaInterface
{
    /**
     * Apply criteria
     *
     * @param QueryBuilder|EloquentBuilder  $model
     * @param RepositoryInterface           $repository
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository);
}
