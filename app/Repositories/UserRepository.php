<?php

namespace App\Repositories;

use App\User;

class UserRepository extends AbstractRepository
{

    function __construct(User $model)
    {
        $this->model = $model;
    }

    public function search($data = [])
    {
        $this->model->select('users.*');

        if(isset($data['is_active'])){
            $this->model->where('is_active', $data['is_active']);
        }

        if(isset($data['roles_id'])){
            $this->model->where('roles_id', $data['roles_id']);
        }

        return $this->model->orderBy('created_at', 'DESC');
    }
}