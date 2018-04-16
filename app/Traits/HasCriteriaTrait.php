<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use App\Contracts\Criteria\CriteriaInterface;

trait HasCriteriaTrait
{
    /**
     * @var Collection
     */
    protected $criteria;

    /**
     * @var bool
     */
    protected $skipCriteria = false;

    /**
     * @var bool
     */
    protected $preventCriteriaOverwriting = true;

    /**
     * @param bool $status
     * @return self|Repository
     */
    public function skipCriteria($status = true)
    {
        $this->skipCriteria = (bool) $status;
    }

    /**
     * @return Collection
     */
    public function getCriteria()
    {
        return $this->criteria ?? new Collection();
    }

    /**
     * @param CriteriaInterface $criteria
     * @return self|Repository
     */
    public function getByCriteria(CriteriaInterface $criteria)
    {
        $this->model = $criteria->apply($this->model, $this);

        return $this;
    }

    /**
     * @param CriteriaInterface $criteria
     * @return self|Repository
     */
    public function pushCriteria(CriteriaInterface $criteria)
    {
        if (null === $this->criteria) {
            $this->criteria = new Collection();
        }

        if ($this->preventCriteriaOverwriting) {
            // Find existing criteria
            $key = $this->criteria->search(function ($item) use ($criteria) {
                return (is_object($item) && (get_class($item) == get_class($criteria)));
            });
            // Remove old criteria
            if ($key !== false) {
                $this->criteria->offsetUnset($key);
            }
        }

        $this->criteria->push($criteria);

        return $this;
    }

    /**
     * @return self|Repository
     */
    public function applyCriteria()
    {
        if ($this->skipCriteria === true) {
            return $this;
        }

        foreach ($this->getCriteria() as $criteria) {
            if ($criteria instanceof CriteriaInterface) {
                $this->model = $criteria->apply($this->model, $this);
            }
        }

        return $this;
    }
}
