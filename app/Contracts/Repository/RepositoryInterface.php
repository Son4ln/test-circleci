<?php

namespace App\Contracts\Repository;

interface RepositoryInterface
{
    /**
     * @param array $columns
     * @return mixed
     */
    public function all($columns = ['*']);

    /**
     * @param int   $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 10, $columns = ['*']);

    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function make(array $data);

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param array $data
     * @return bool
     */
    public function saveModel(array $data): bool;

    /**
     * @param array $data
     * @param mixed $id
     * @return mixed
     */
    public function update(array $data, $id);

    /**
     * @param mixed $id
     * @return mixed
     */
    public function delete($id);

    /**
     * @param mixed $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = ['*']);

    /**
     * @param mixed $id
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail($id, $columns = ['*']);

    /**
     * @param string $field
     * @param mixed  $value
     * @param array  $columns
     * @return mixed
     */
    public function findBy($field, $value, $columns = ['*']);

    /**
     * @param string $field
     * @param mixed  $value
     * @param array  $columns
     * @return mixed
     */
    public function findAllBy($field, $value, $columns = ['*']);

    /**
     * @param array $where
     * @param array $columns
     * @return mixed
     */
    public function findWhere($where, $columns = ['*']);

    /**
     * @param array $relations
     * @return self
     */
    public function with(...$relations);
}
