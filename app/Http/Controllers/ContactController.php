<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\StoreContactRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

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

    public function show(Contact $contact)
    {
        //
    }

    public function update(Request $request, Contact $contact)
    {
        //
    }

    public function destroy(Contact $contact)
    {
        //
    }
}
