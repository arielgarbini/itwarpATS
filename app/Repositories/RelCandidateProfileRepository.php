<?php

namespace App\Repositories;

use App\RelCandidateProfile;

class RelCandidateProfileRepository extends AbstractRepository
{
    function __construct(RelCandidateProfile $model)
    {
        $this->model = $model;
    }

    public function search($data = [])
    {
        $this->model->select('rel_candidates_profiles.*');

        if(isset($data['candidates_id'])){
            $this->model->where('candidates_id', $data['candidates_id']);
        }

        return $this->model->orderBy('id', 'DESC');
    }
}