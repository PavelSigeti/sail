<?php

namespace App\Http\Repositories;

use App\Models\Stage as Model;

class StageRepository extends CoreRepository
{

    protected function getModelClass()
    {
        return Model::class;
    }

    public function getByTournamentId($id)
    {
        $columns = [
            'race_start', 'id', 'title',
        ];
        $result = $this->startConditions()
            ->select($columns)
            ->where('tournament_id', $id)
            ->get();

        return $result;
    }

    public function getById($id)
    {
        $result = $this->startConditions()
            ->find($id);

        return $result;
    }

    public function getByIdWithUsers($id)
    {
        $result = $this->startConditions()
            ->with('users')
            ->find($id);

        return $result;
    }

    public function getByIdWithRaces($id)
    {
        $result = $this->startConditions()
            ->with('races')
            ->find($id);

        return $result;
    }

}
