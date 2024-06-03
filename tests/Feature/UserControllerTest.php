<?php

use App\Http\Resources\UserResource;
use App\Models\User;

test('list users', function () {
    User::factory(2)->create();

    $users = User::query()->paginate();

    $resource = UserResource::collection($users);

    $resourceArray = $resource->response()->getData(true);

    $response = $this->get(route('users.index'))
        ->assertOk();

    $this->assertSame($response->json()['data'], $resourceArray['data']);
});

test('create user', function () {
    $payload = [
        'name' => 'Test create user',
        'email' => 'test_create@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    $response = $this->post(route('users.store'), $payload)
        ->assertCreated()
        ->json();

    $this->assertSame($response['name'], $payload['name']);
    $this->assertSame($response['email'], $payload['email']);

    $this->assertDatabaseHas('users', [
        'name' => $payload['name'],
        'email' => $payload['email'],
    ]);
});

test('update user', function () {
    $userToUpdate = User::factory()->create([
        'name' => 'Test create user',
        'email' => 'test_create@example.com',
    ]);

    $payload = [
        'name' => 'Test create user 2',
        'email' => 'test_create2@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    $response = $this->put(route('users.update', $userToUpdate->id), $payload)
        ->assertOk()
        ->json();

    $this->assertSame($response['name'], $payload['name']);
    $this->assertSame($response['email'], $payload['email']);

    $this->assertDatabaseHas('users', [
        'id' => $userToUpdate->id,
        'name' => $payload['name'],
        'email' => $payload['email'],
    ]);
});

test('delete user', function () {
    $userToDelete = User::factory()->create();

    $this->delete(route('users.destroy', $userToDelete->id))
        ->assertNoContent();

    $this->assertSoftDeleted($userToDelete);
});
