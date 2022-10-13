<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\CalcTotal;
use App\Actions\Admin\StageStartAction;
use App\Http\Controllers\Controller;
use App\Http\Repositories\RaceRepository;
use App\Http\Repositories\StageRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\StageStoreRequest;
use App\Http\Requests\StageUpdateRequest;
use App\Models\Stage;

class StageController extends Controller
{
    protected $stageRepository;
    protected $raceRepository;
    protected $userRepository;

    public function __construct() {
        $this->stageRepository = app(StageRepository::class);
        $this->raceRepository = app(RaceRepository::class);
        $this->userRepository = app(UserRepository::class);
    }

    public function store(StageStoreRequest $request) {
        $stage = Stage::query()->create([
            'tournament_id' => $request->tournament_id,
            'register_start' => $request->register_start,
            'register_end' => $request->register_end,
            'race_start' => $request->race_start,
            'title' => $request->title,
            'excerpt' => $request->excerpt,
            'description' => $request->description,
        ]);

        return $stage;
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

        return $action($stage);
    }

    public function getStageGroupStatusTotal($stageId, $groupId, $status, CalcTotal $action)
    {
        $result = $this->userRepository->getGroupData($stageId, $groupId, $status);
        $drops = $this->stageRepository->getStageDrops($stageId, $status);

        return $action($result, $drops);
    }

    public function update(StageUpdateRequest $request, $id)
    {
        $stage = $this->stageRepository->getById($id);

        $stage->update([
            'register_start' => $request->register_start,
            'register_end' => $request->register_end,
            'race_start' => $request->race_start,
            'title' => $request->title,
            'excerpt' => $request->excerpt,
            'description' => $request->description,
            'race_amount_drop' => $request->race_amount_drop,
            'race_amount_group_drop' => $request->race_amount_group_drop,
            'race_amount_flot_drop' => $request->race_amount_flot_drop,
        ]);

        return true;
    }
}
