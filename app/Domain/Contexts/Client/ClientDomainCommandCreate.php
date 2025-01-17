<?php

namespace App\Domain\Contexts\Client;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Data;

class ClientDomainCommandCreate extends Data
{
    public function __construct(
        #[Max(255)]
        public string $name,
        #[Max(255)]
        public ?string $email,
        #[Max(255)]
        public ?string $phoneNumber,
        public int $telegramId
    )
    {
    }
}
