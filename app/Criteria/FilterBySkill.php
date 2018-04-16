<?php

namespace App\Criteria;

use App\Contracts\Criteria\CriteriaInterface;
use App\Contracts\Repository\RepositoryInterface;
use Illuminate\Http\Request;

/**
 * Class FilterBySkill
 */
class FilterBySkill implements CriteriaInterface
{
    /**
     * @var String
     */
    protected $skill;

    /**
     * FilterByBot constructor.
     *
     * @param Request $request
     */
    public function __construct($skill)
    {
        $this->skill = $skill;
    }

    /**
     * @param mixed $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        if(count($this->skill) > 0) {
            $model->whereHas('userSkills', function($query) {
                $query->whereIn('kind', $this->skill);
            });            
        }

        return $model;
    }
}
