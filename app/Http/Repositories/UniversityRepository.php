<?php

namespace App\Http\Repositories;

use App\Models\University as Model;

class UniversityRepository extends CoreRepository
{

    protected function getModelClass()
    {
        return Model::class;
    }

    public function getAll()
    {
        return $this->startConditions()->all();
    }
}
