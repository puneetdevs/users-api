<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repositories\UserRepository;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public UserRepository $userRepo;

    public function __construct(UserRepository $repo)
    {
        $this->userRepo = $repo;
    }

    public function index(Request $request)
    {
        $users = $this->userRepo->list($request);
        return response()->json($users);
    }
}
