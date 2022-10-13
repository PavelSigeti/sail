<?php

namespace App\Http\Repositories;

use App\Models\User as Model;

class UserRepository extends CoreRepository
{

    protected function getModelClass()
    {
        return Model::class;
    }

    public function getStageData($id)
    {
        $result = $this->startConditions()
            ->join('race_user', 'users.id', '=', 'race_user.user_id')
            ->join('stage_user', 'users.id', '=', 'stage_user.user_id')
            ->join('races', 'race_user.race_id', '=', 'races.id')
            ->select('race_user.race_id', 'users.id', 'race_user.place',
                'races.group_id', 'users.name', 'races.stage_id',
                'races.status',
            )
            ->where('races.stage_id', $id)
            ->orderBy('race_user.race_id')
            ->get()
            ->groupBy(['status', 'group_id', 'id']);

        return $result;
    }

    public function getGroupData($groupId, $stageId, $status)
    {
        $result = $this->startConditions()
            ->join('race_user', 'users.id', '=', 'race_user.user_id')
            ->join('stage_user', 'users.id', '=', 'stage_user.user_id')
            ->join('races', 'race_user.race_id', '=', 'races.id')
            ->select('race_user.race_id', 'users.id', 'race_user.place',
                'races.group_id', 'races.stage_id',
                'races.status',
            )
            ->where('races.stage_id', $stageId)
            ->where('races.group_id', $groupId)
            ->where('races.status', $status)
            ->orderBy('race_user.race_id')
            ->get()
            ->groupBy(['id']);

        return $result;
    }
}
