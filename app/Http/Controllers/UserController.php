<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function index(): ResourceCollection
    {
        $users = User::query()->paginate();

        return UserResource::collection($users);
    }

    public function store(StoreUserRequest $request): JsonResource
    {
        $user = User::query()->create(
            $request->validated()
        );

        return new UserResource($user);
    }

    public function show(User $user): JsonResource
    {
        return new UserResource($user);
    }

    public function update(Request $request, User $user)
    {
        //
    }

    public function destroy(User $user): Response
    {
        $user->delete();

        return response()->noContent();
    }
}
