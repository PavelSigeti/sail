<?php

namespace App\Actions\Admin;

class CalcStageGroupTable
{
    public function __invoke($results, $drops)
    {
        $response = clone $results;
        $dnf = count($results) + 1;
        foreach ($results as $userId => $user) {
            foreach ($user as $key => $race) {
                if($race['place'] === null) {
                    $results[$userId][$key]['place'] = $dnf;
                }
            }
            $results[$userId] = $user->sort(function($a, $b){
                return ($a->place > $b->place) ? 1 : -1;
            });
            if($drops > 0 && $results[$userId]->count() >= $drops) {
                for($i=1; $i<=$drops; $i++) {
                    $dropId = $results[$userId]->last()->race_id;
                    $results[$userId] = $results[$userId]
                        ->splice(0, $results[$userId]->count() - 1);
                    $response[$userId]->where('race_id', $dropId)->first()->drop = true;
                }
            }
            $response[$userId]['total'] = $results[$userId]->sum(['place']);
        }


        return $response;
    }
}
