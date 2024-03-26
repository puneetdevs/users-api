<?php
namespace App\Http\Repositories;
use App\Models\ApiUser;

class UserRepository  {

    public function list($request) 
    {
        $page = $request->query('page', 1);
        $perPage = $request->query('per_page', 10);
        $users = ApiUser::paginate($perPage, ['*'], 'page', $page);
        return $users;
    }
}