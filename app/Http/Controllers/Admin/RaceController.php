<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\CreateRaceAction;
use App\Http\Controllers\Controller;
use App\Http\Repositories\RaceRepository;
use App\Http\Requests\CreateRaceRequest;
use App\Http\Requests\StoreResultsRequest;

class RaceController extends Controller
{
    protected $raceRepository;

    public function __construct() {
        $this->raceRepository = app(RaceRepository::class);
    }

    public function getStageRaces($stageId, $status, $groupId)
    {
        return $this->raceRepository->getStageRaces($stageId, $status, $groupId);
    }

    public function getRaceUsers($id)
    {
        return $this->raceRepository->getRaceUsers($id);
    }

    public function getRacePlace($id)
    {
        return $this->raceRepository->getRacePlace($id);
    }

    public function storeResults(StoreResultsRequest $request, $id) {

        $race = $this->raceRepository->getById($id);
        $results = collect($request->result);

        $results = $results->mapWithKeys(function ($item, $key) {
            return [$key => ['place' => $item]];
        });

        $race->users()->sync($results);

//        foreach ($results as $raceId => $place) {
//            $race->users()->detach($raceId);
//            if($place === null) {
//                $race->users()->attach($raceId, ['place' => count($results) + 1]);
//            } else {
//                $race->users()->attach($raceId, ['place' => $place]);
//            }
//        }


        return ['result111' => $results, ];
    }

    public function createRace(CreateRaceRequest $request, CreateRaceAction $action)
    {
        $users = $this->raceRepository->getRaceUsers($request->lastRaceId)->keyBy('user_id');

        $result = $action($request, $users);

        return $result;
    }

    public function destroy($id)
    {
        $race = $this->raceRepository->getById($id);

        $race->delete();

        return true;
    }

}
