<?php

namespace App\Http\Controllers;

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
        return view('user-listing', ['users' => $users]);
    }
}
