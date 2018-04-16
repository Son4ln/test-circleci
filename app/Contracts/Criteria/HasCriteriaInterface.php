<?php

namespace App\Contracts\Criteria;

use Illuminate\Support\Collection;

interface HasCriteriaInterface
{
    /**
     * @param bool $status
     * @return self|Repository
     */
    public function skipCriteria($status = true);

    /**
     * @return Collection
     */
    public function getCriteria();

    /**
     * @param CriteriaInterface $criteria
     * @return self|Repository
     */
    public function getByCriteria(CriteriaInterface $criteria);

    /**
     * @param CriteriaInterface $criteria
     * @return self|Repository
     */
    public function pushCriteria(CriteriaInterface $criteria);

    /**
     * @return self|Repository
     */
    public function applyCriteria();
}
