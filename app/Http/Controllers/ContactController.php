<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\StoreContactRequest;
use App\Http\Requests\Contact\UpdateContactRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class ContactController extends Controller
{
    public function index(User $user): ResourceCollection
    {
        $contacts = Contact::query()
            ->whereBelongsTo($user)
            ->paginate();

        return ContactResource::collection($contacts);
    }

    public function store(StoreContactRequest $request, User $user): JsonResource
    {
        $contact = $user->contacts()->create($request->validated());

        return new ContactResource($contact);
    }

    public function show(User $user, Contact $contact): JsonResource
    {
        return new ContactResource($contact);
    }

    public function update(UpdateContactRequest $request, User $user, Contact $contact): JsonResource
    {
        $contact->update(
            array_filter($request->validated())
        );

        return new ContactResource($contact);
    }

    public function destroy(User $user, Contact $contact): Response
    {
        $contact->delete();

        return response()->noContent();
    }
}
