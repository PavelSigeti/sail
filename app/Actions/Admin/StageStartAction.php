<?php

namespace App\Actions\Admin;

use App\Models\Race;
use App\Models\Stage;

class StageStartAction
{
    public function __invoke($stage)
    {
        $playersAmount = $stage->users->count();

        if($playersAmount === 0) {
            return ['error' => 'Нет пользователей'];
        }

        if ($playersAmount > 18) {
//            $groupAmount = (int)ceil($playersAmount / 18);
//            $users = $stage->users->shuffle()->keyBy('id')->toArray();
//            $userGroups = array_chunk($users, ceil($playersAmount/ $groupAmount) );
//
//            $stage->update([
//                'status' => 'group',
//            ]);
//            for ($i=1; $i<=$groupAmount; $i++) {
//                $group[] = Group::query()->create([
//                    'number' => $i,
//                    'type' => 'group',
//                    'stage_id' => $stage->id,
//                    'user_amount' => count($userGroups[$i-1])
//                ]);
//                for ($j=1; $j<=$stage->race_amount_group; $j++)
//                    Race::query()->create([
//                        'stage_id' => $stage->id,
//                        'number' => $j,
//                        'type' => 'group',
//                        'group_id' => $group[$i-1]->id,
//                    ]);
//            }
//            foreach ($userGroups as $key => $userGroup) {
//                foreach ($userGroup as $user) {
//                    $group[$key]->users()->attach($user['id']);
//                }
//            }

            return true;

        } else {
            if(Race::query()->where('stage_id', $stage->id)->count() === 0) {
                $race = Race::query()->create([
                    'stage_id' => $stage->id,
                    'status' => 'default',
                ]);
                $users = $stage->users->keyBy('id')->toArray();
                foreach ($users as $user) {
                    $race->users()->attach($user['id']);
                }

                $stage->update([
                    'status' => 'default',
                ]);
                return ['status' => 'default'];
            }
            return ['error' => 'Ошибка, гонка уже созданая'];
        }
    }
}
