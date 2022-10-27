<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserSearchRequest;
use App\Models\User;

class UserController extends Controller
{
    public function search(UserSearchRequest $request)
    {
        $select = [
          'id', 'nickname', 'name', 'surname',
        ];
        $result = User::query()
            ->select($select)
            ->whereNull('team_id')
            ->where(function($query) use ($request) {
                $query->where('nickname', 'LIKE', "%{$request->user}%");
                $query->orWhere('id', 'LIKE', "%{$request->user}%");
            })
            ->get();

        return $result;
    }
}
