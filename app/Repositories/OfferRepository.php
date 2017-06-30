<?php

namespace App\Repositories;

use App\Offer;

class OfferRepository extends AbstractRepository
{

    function __construct(Offer $model)
    {
        $this->model = $model;
    }
}