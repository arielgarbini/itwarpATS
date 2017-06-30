<?php

namespace App\Repositories;

use App\Address;

class AddressRepository extends AbstractRepository
{

    function __construct(Address $model)
    {
        $this->model = $model;
    }

}