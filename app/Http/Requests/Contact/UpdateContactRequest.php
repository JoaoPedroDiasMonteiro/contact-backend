<?php

namespace App\Http\Requests\Contact;

use App\Enums\ContactType;
use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContactRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => ['nullable', 'string', 'max:255', Rule::enum(ContactType::class)],
            'value' => [
                'nullable', 'string', 'max:255',
                Rule::when($this->type === ContactType::EMAIL->value, ['email:rfc,dns,filter']),
                Rule::when($this->type === ContactType::PHONE->value, new PhoneNumber()),
                Rule::when($this->type === ContactType::WHATSAPP->value, new PhoneNumber()),
            ],
        ];
    }
}
