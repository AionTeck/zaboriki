<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Data;

class FenceRequest extends Data
{
    public function __construct(
        #[IntegerType]
        #[Min(1)]
        public ?string $typeId
    )
    {
    }
}
