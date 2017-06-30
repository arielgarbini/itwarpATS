<?php

namespace App\Repositories;

use App\CandidateWorkStatus;

class CandidateWorkStatusRepository extends AbstractRepository
{

    function __construct(CandidateWorkStatus $model)
    {
        $this->model = $model;
    }
    public function search($data = [])
    {
        $this->model->select('candidateworkstatus.*');

        return $this->model->orderBy('id');
    }


}