<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\StageStartAction;
use App\Http\Controllers\Controller;
use App\Http\Repositories\RaceRepository;
use App\Http\Repositories\StageRepository;
use App\Http\Requests\StageStoreRequest;
use App\Models\Stage;

class StageController extends Controller
{
    protected $stageRepository;
    protected $raceRepository;

    public function __construct() {
        $this->stageRepository = app(StageRepository::class);
        $this->raceRepository = app(RaceRepository::class);
    }

    public function store(StageStoreRequest $request) {
        Stage::query()->create([
            'tournament_id' => $request->tournament_id,
            'register_start' => $request->register_start,
            'register_end' => $request->register_end,
            'race_start' => $request->race_start,
            'title' => $request->title,
            'excerpt' => $request->excerpt,
            'description' => $request->description,
        ]);

        return true;
    }

    public function tournament($id)
    {
        return $this->stageRepository->getByTournamentId($id);
    }

    public function edit($id)
    {
        return $this->stageRepository->getByIdWithUsers($id);
    }

    public function getStageStatusGroup($id)
    {
        return $this->raceRepository->getStageStatusGroup($id);
    }

    public function startStage($id, StageStartAction $action)
    {
        $stage = $this->stageRepository->getByIdWithRaces($id);
        $data = $action($stage);

        return $data;
    }


}
