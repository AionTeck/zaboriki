<?php

namespace App\Domain\Contexts\Contact;

use Spatie\LaravelData\Data;

class ContactsDomainCommandSendRequest extends Data
{
    public function __construct(
        public int $userId,
        public string $message
    )
    {
    }
}
