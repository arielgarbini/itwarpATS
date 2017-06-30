<?php

namespace App\Repositories;

use App\CandidateOfferComment;

class CandidateOfferCommentRepository extends AbstractRepository
{

    function __construct(CandidateOfferComment $model)
    {
        $this->model = $model;
    }

    public function search($data = [])
    {
        $this->model->select('candidateoffercomments.*');

        if(isset($data['rel_offers_candidates_id'])){
            $this->model->where('rel_offers_candidates_id', $data['rel_offers_candidates_id']);
        }

        return $this->model->orderBy('created_at', 'DESC');
    }
}