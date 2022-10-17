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
            ->orderBy('id', 'desc')
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

    public function getStageDrops($id, $status) {
        $dropField = [
            'default' => 'race_amount_drop',
            'group' => 'race_amount_group_drop',
            'fleet' => 'race_amount_fleet_drop',
        ];
        $result = $this->startConditions()
            ->find($id)
            ->pluck($dropField[$status])
            ->first();

        return $result;
    }

}
