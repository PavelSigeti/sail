<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Repositories\UserRepository;

class StageController extends Controller
{
    protected $userRepository;

    public function __construct()
    {
        $this->userRepository = app(UserRepository::class);
    }

    public function __invoke($id)
    {
        $data = $this->userRepository->getStageData($id);



        return $data;
    }
}
