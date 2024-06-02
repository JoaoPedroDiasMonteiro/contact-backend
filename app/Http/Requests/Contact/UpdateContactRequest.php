<?php

namespace App\Http\Requests\Contact;

use App\Enums\ContactType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContactRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => ['nullable', 'string', 'max:255', Rule::enum(ContactType::class)],
            'value' => ['nullable', 'string', 'max:255']];
    }
}
