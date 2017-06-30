<?php

namespace App\Repositories;

use App\Profile;

class ProfileRepository extends AbstractRepository
{

    function __construct(Profile $model)
    {
        $this->model = $model;
    }

    public function search($data = [])
    {
        $this->model->select('profiles.*');

        if(isset($data['is_active'])){
            $this->model->where('is_active', $data['is_active']);
        }

        if(isset($data['profile'])){
            $this->model->where('profile', 'LIKE',  '%'.$data['profile'].'%');
        }

        return $this->model->orderBy('id', 'DESC');
    }
}