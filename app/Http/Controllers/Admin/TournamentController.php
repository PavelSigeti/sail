<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TournamentStoreRequest;
use App\Models\Tournament;

class TournamentController extends Controller
{
    public function index()
    {

    }

    public function store(TournamentStoreRequest $request)
    {
        $tournament = Tournament::query()->create([
            'title' => $request->title,
            'yacht' => $request->yacht,
            'description' => $request->description,
        ]);

        return ['id' => $tournament->id];
    }

    public function edit($id) {
        return Tournament::query()->find($id);
    }

    public function update(TournamentStoreRequest $request, $id) {
        Tournament::query()->update([
            'title' => $request->title,
            'yacht' => $request->yacht,
            'description' => $request->description,
        ]);

        return true;
    }
}
