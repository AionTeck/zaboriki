<?php

namespace App\Domain\Contexts\Fence;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Data;

class FenceDomainQueryUniqueList extends Data
{
    public function __construct(
        #[IntegerType]
        #[Min(1)]
        public ?int $typeId,
    ) {
    }
}
