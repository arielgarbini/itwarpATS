<?php

namespace App\Repositories;

use App\Country;

class CountryRepository extends AbstractRepository
{
    function __construct(Country $model)
    {
        $this->model = $model;
    }

    public function search($data = [])
    {
        $this->model->select('countries.*');

        return $this->model->orderBy('country', 'ASC');
    }
}