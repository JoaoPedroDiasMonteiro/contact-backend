<?php

use App\Http\Resources\ContactResource;
use App\Models\Contact;
use App\Models\User;

function createUser(): User
{
    return User::factory()->create();
}

test('list contacts', function () {
    $user = createUser();

    Contact::factory(2)->for($user)->create();

    $contacts = $user->contacts()->paginate();

    $resource = ContactResource::collection($contacts);

    $resourceArray = $resource->response()->getData(true);

    $response = $this->get(route('contacts.index', ['user' => $user]))
        ->assertOk();

    $this->assertSame($response->json()['data'], $resourceArray['data']);
});

test('create contact', function () {
    $user = createUser();

    $payload = [
        'type' => 'whatsapp',
        'value' => '70707070707070',
    ];

    $response = $this->post(route('contacts.store', ['user' => $user]), $payload)
        ->assertCreated()
        ->json();

    $this->assertSame($response['type'], $payload['type']);
    $this->assertSame($response['value'], $payload['value']);

    $this->assertDatabaseHas('contacts', [
        'type' => $payload['type'],
        'value' => $payload['value'],
    ]);
});

test('update contact', function () {
    $user = createUser();

    $contactToUpdate = Contact::factory()->for($user)->create([
        'type' => 'whatsapp',
        'value' => '70707070707070',
    ]);

    $payload = [
        'type' => 'email',
        'value' => 'test@example.com',
    ];

    $response = $this->put(route('contacts.update', ['user' => $user, 'contact' => $contactToUpdate]), $payload)
        ->assertOk()
        ->json();

    $this->assertSame($response['type'], $payload['type']);
    $this->assertSame($response['value'], $payload['value']);

    $this->assertDatabaseHas('contacts', [
        'id' => $contactToUpdate->id,
        'type' => $payload['type'],
        'value' => $payload['value'],
    ]);
});

test('delete contact', function () {
    $user = createUser();

    $contactToDelete = Contact::factory()->for($user)->create();

    $this->delete(route('contacts.destroy', ['user' => $user, 'contact' => $contactToDelete]))
        ->assertNoContent();

    $this->assertSoftDeleted($contactToDelete);
});
