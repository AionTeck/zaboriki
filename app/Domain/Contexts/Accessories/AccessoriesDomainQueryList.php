<?php

namespace App\Domain\Contexts\Accessories;

use App\Enum\AccessoryableType;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Data;

class AccessoriesDomainQueryList extends Data
{
    public function __construct(
        #[Enum(AccessoryableType::class)]
        public ?AccessoryableType $accessoriableType
    )
    {
    }
}
