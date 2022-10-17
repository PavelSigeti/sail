<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Http\Repositories\UniversityRepository;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    protected $universityRepository;

    public function __construct()
    {
        $this->universityRepository = app(UniversityRepository::class);
    }

    public function __invoke()
    {
        $universities = $this->universityRepository->getAll();

        return $universities;
    }
}
