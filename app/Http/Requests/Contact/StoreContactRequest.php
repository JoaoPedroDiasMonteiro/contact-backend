<?php

namespace App\Http\Requests\Contact;

use App\Enums\ContactType;
use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreContactRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => ['required', 'string', 'max:255', Rule::enum(ContactType::class)],
            'value' => [
                'required', 'string', 'max:255',
                Rule::when($this->type === ContactType::EMAIL->value, ['email:rfc,dns,filter']),
                Rule::when($this->type === ContactType::PHONE->value, new PhoneNumber()),
                Rule::when($this->type === ContactType::WHATSAPP->value, new PhoneNumber()),
            ],
        ];
    }
}
