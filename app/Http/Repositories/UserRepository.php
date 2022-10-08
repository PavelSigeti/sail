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
        $columns = [];

        $result = $this->startConditions()
            ->join('race_user', 'users.id', '=', 'race_user.user_id')
            ->join('stage_user', 'users.id', '=', 'stage_user.user_id')
            ->join('races', 'race_user.race_id', '=', 'races.id')
            ->select('race_user.race_id', 'users.id', 'race_user.place',
                'races.group_id', 'users.name', 'races.stage_id',
                'races.status',
//                'stage_user.nickname',  'users.surname'
            )
            ->where('races.stage_id', $id)
            ->orderBy('race_user.race_id')
            ->get()
            ->groupBy(['status', 'group_id', 'id'])
//            ->mapToGroups(function ($item, $key) {
//
//                return [$item['id'] => $item];
//            })
        ;

        return $result;
    }
}
