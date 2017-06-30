<?php

namespace App\Repositories;

use DB;
use Eloquent;
use Illuminate\Database\Eloquent\Model;

class AbstractRepository {
    /**
     * @var Model $model
     */
    protected $model;
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    function all()
    {
        return $this->model->all();
    }
    /**
     * @return static
     */
    function newInstance()
    {
        return $this->model->newInstance();
    }
    /**
     * @param $id
     *
     * @return Model
     */
    function getById($id)
    {
        return $this->model->findOrFail($id);
    }
    function find($id, $columns = array('*'))
    {
        return $this->model->find($id, $columns);
    }
    function first()
    {
        return $this->model->first();
    }

    function last()
    {
        return $this->model->orderBy('created_at','desc')->first();
    }
    /**
     * @param array $attributes
     *
     * @return static
     */
    function firstOrCreate(array $attributes = []) {
        return $this->model->firstOrCreate($attributes);
    }
    /**
     * @param array $input
     *
     * @return Model
     */
    function create(array $input)
    {
        return $this->model->create($input);
    }
    /**
     * @param array $input
     *
     * @return static
     */
    function forceCreate(array $input)
    {
        $this->model->unguard();
        $instance = $this->model->create($input);
        $this->model->reguard();
        return $instance;
    }
    /**
     * @throws \Exception
     */
    public function deleteAll()
    {
        $this->model->delete();
    }
    /**
     * @param Eloquent $model
     *
     * @return mixed
     */
    public function save(Eloquent $model)
    {
        return $model->save();
    }
    public function update(Model $model, array $attributes)
    {
        return $model->update($attributes);
    }
    /**
     * Delete an Eloquent Model from database
     *
     * @param Model $model
     *
     * @return bool|null
     * @throws \Exception
     */
    public function delete(Model $model)
    {
        return $model->delete();
    }
    /**
     * Force a hard delete on a soft deleted model.
     *
     * This method protects developers from running forceDelete when trait is missing.
     *
     * @return bool|null
     */
    public function forceDelete(Model $model)
    {
        return $model->forceDelete();
    }
    public function truncate()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->model->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1 ;');
    }
}