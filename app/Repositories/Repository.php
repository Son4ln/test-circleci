<?php

namespace App\Repositories;

use Auth;
use Illuminate\Contracts\Container\Container as App;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Traits\Macroable;
use App\Contracts\Criteria\HasCriteriaInterface;
use App\Traits\HasCriteriaTrait;
use App\Contracts\Repository\RepositoryInterface;
use App\Contracts\Criteria\CriteriaInterface;

abstract class Repository implements RepositoryInterface, HasCriteriaInterface
{
    use Macroable;
    use HasCriteriaTrait;

    /**
     * @var App
     */
    protected $app;

    /**
     * @var Model
     */
    protected $model;

    /**
     * Repository constructor.
     *
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;

        $this->resetScope();
        $this->makeModel();
    }

    /**
     * Model class name.
     *
     * @return string
     */
    abstract public function modelName(): string;

    /**
     * @return mixed
     * @throws RepositoryException
     */
    protected function makeModel()
    {
        $this->model = $this->app->make($this->modelName());

        if (!$this->model instanceof Model) {
            throw new RepositoryException(
                "Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model"
            );
        }

        return $this->model;
    }

    /**
     * @param array $columns
     * @return mixed
     */
    public function all($columns = ['*'])
    {
        $this->applyCriteria();

        return $this->model->get($columns);
    }

    /**
     * @param array ...$relations
     * @return self
     */
    public function with(...$relations)
    {
        $this->model = $this->model->with($relations);

        return $this;
    }

    /**
     * @param string        $valueField
     * @param string|null   $keyField
     * @return array
     */
    public function lists($valueField, $keyField = null)
    {
        $this->applyCriteria();

        $lists = $this->model->pluck($valueField, $keyField);
        if (!is_array($lists)) {
            $lists->toArray();
        }

        return $lists;
    }

    public function first()
    {
        $this->applyCriteria();

        return $this->model->first();
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @return LengthAwarePaginator
     */
    public function paginate($perPage = 10, $columns = ['*'])
    {
        $this->applyCriteria();

        return $this->model->paginate($perPage, $columns);
    }

    /**
     * @param array $data
     * @return Model
     */
    public function make(array $data)
    {
        return $this->model->fill($data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function saveModel(array $data): bool
    {
        foreach ($data as $key => $value) {
            $this->model->{$key} = $value;
        }

        return $this->model->save();
    }

    /**
     * @param array $data
     * @param mixed $id
     * @return mixed
     */
    public function update(array $data, $id)
    {
        return $this->model->where($this->model->getKeyName(), '=', $id)
            ->update($data);
    }

    /**
     * @param mixed $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * @param mixed $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = ['*'])
    {
        $this->applyCriteria();

        return $this->model->find($id, $columns);
    }

    /**
     * @param mixed $id
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail($id, $columns = ['*'])
    {
        $this->applyCriteria();

        return $this->model->findOrFail($id, $columns);
    }

    /**
     * @param string $field
     * @param mixed  $value
     * @param array  $columns
     * @return mixed
     */
    public function findBy($field, $value, $columns = ['*'])
    {
        $this->applyCriteria();

        return $this->model->where($field, '=', $value)->first($columns);
    }

    /**
     * @param string $field
     * @param mixed  $value
     * @param array  $columns
     * @return mixed
     */
    public function findAllBy($field, $value, $columns = ['*'])
    {
        $this->applyCriteria();

        return $this->model->where($field, '=', $value)->get($columns);
    }

    /**
     * @param array $where
     * @param array $columns
     * @return mixed
     */
    public function findWhere($where, $columns = ['*'])
    {
        $this->applyCriteria();

        return $this->model->where($where)->get($columns);
    }

    /**
     * @return self
     */
    public function resetScope()
    {
        $this->skipCriteria(false);

        return $this;
    }
}
