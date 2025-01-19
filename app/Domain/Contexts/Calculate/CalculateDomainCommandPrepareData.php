<?php

namespace App\Domain\Contexts\Calculate;

use Spatie\LaravelData\Data;

class CalculateDomainCommandPrepareData extends Data
{
    public function __construct(
        public ?array $fence,
        public array $gates,
        public int $mountingId,
        public string $report_id
    )
    {
    }
}
