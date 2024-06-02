<?php

namespace App\Enums;

enum ContactType: string
{
    case EMAIL = 'email';
    case WHATSAPP = 'whatsapp';
    case PHONE = 'phone';
}
