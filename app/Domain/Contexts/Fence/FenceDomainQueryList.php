<?php

namespace App\Domain\Contexts\Fence;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Data;

class FenceDomainQueryList extends Data
{
    public function __construct(
        #[IntegerType]
        #[Min(1)]
        public ?string $typeId
    )
    {
    }
}
