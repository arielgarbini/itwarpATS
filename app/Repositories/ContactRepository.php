<?php

namespace App\Repositories;

use App\Contact;

class ContactRepository extends AbstractRepository
{

    function __construct(Contact $model)
    {
        $this->model = $model;
    }
}