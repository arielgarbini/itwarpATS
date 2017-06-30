<?php

namespace App\Repositories;

use App\Candidate;

class CandidateRepository extends AbstractRepository
{
    function __construct(Candidate $model)
    {
        $this->model = $model;
    }
}