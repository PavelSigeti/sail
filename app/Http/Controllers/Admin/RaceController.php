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

        return true;
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
        $count = $this->raceRepository->getSameRaces($race->stage_id, $race->group_id, $race->status);

        if($count > 1) {
            $race->delete();
        }


        return true;
    }

}
