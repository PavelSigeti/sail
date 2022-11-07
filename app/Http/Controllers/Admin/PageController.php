<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\PageRepository;
use Illuminate\Http\Request;

class PageController extends Controller
{
    protected $pageRepository;

    public function __construct()
    {
        $this->pageRepository = app(PageRepository::class);
    }

    public function index()
    {
        return $this->pageRepository->getAll();
    }
}
