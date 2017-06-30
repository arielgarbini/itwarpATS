<?php

namespace App\Repositories;

use App\Rol;

class RoleRepository extends AbstractRepository
{
    function __construct(Rol $model)
    {
        $this->model = $model;
    }

    public function search($data = [])
    {
        $this->model->select('roles.*');

        return $this->model->orderBy('id', 'ASC');
    }

}