<?php

namespace App\Repositories;

use App\State;

class StateRepository extends AbstractRepository
{
    function __construct(State $model)
    {
        $this->model = $model;
    }

    public function search($data = [])
    {
        $this->model->select('states.*');

        if(isset($data['countries_id'])){
            $this->model->where('countries_id', $data['countries_id']);
        }

        return $this->model->orderBy('state', 'ASC');
    }
}