<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Repositories\TeamInviteRepository;
use App\Http\Requests\TeamStoreRequest;
use App\Models\Team;
use App\Models\TeamInvite;
use Illuminate\Support\Facades\Auth;


class TeamController extends Controller
{
    protected $teamInviteRepository;

    public function __construct()
    {
        $this->teamInviteRepository = app(TeamInviteRepository::class);
    }


    public function edit()
    {
        $user = Auth::user();
        $owner = ($user->team_id !== null) ? ($user->id === $user->team->owner_id) ? true : false : false;
        $invites = $this->teamInviteRepository->getByUserId($user->id);
        if($owner) {
            $teamInvites = $this->teamInviteRepository->getByTeamId($user->team_id);
            $teammates = $user->team->users;
        } else {
            $teamInvites = null;
            $teammates = null;
        }

        return [
            'team' => $user->team,
            'invites' => $invites,
            'owner' => $owner,
            'teammates' => $teammates,
            'teamInvites' => $teamInvites,
        ];
    }

    public function store(TeamStoreRequest $request)
    {
        $user = Auth::user();
        $team = Team::query()->create([
            'name' => $request->name,
            'owner_id' => $user->id,
        ]);

        $user->update([
            'team_id' => $team->id,
        ]);

        return $team;
    }
}
