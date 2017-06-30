<?php

namespace App\Repositories;

use App\Source;

class SourceRepository extends AbstractRepository
{

    function __construct(Source $model)
    {
        $this->model = $model;
    }

    public function search($data = [])
    {
        $this->model->select('sources.*');

        return $this->model->orderBy('id', 'DESC');
    }
}