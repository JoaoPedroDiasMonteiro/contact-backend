<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function index(Request $request): ResourceCollection
    {
        $relationships = explode(',', $request->get('with', ''));

        $users = User::query()
            ->when(in_array('contacts', $relationships), function (Builder $query) {
                $query->with(['contacts' => fn (Builder $query) => $query->limit(10)]);
            })
            ->paginate();

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

    public function update(UserUpdateRequest $request, User $user): JsonResource
    {
        $user->update(
            array_filter($request->validated())
        );

        return new UserResource($user);
    }

    public function destroy(User $user): Response
    {
        $user->delete();

        return response()->noContent();
    }
}
