<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\StoreUserRequest;
use App\Http\Resources\V1\UserResource;
use App\Http\Controllers\Controller;
use App\Models\User;


class UserController extends Controller
{
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        return new UserResource(User::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

}
