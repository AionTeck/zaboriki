<?php

namespace App\Console\Commands;

use App\Enum\AccessoryableType;
use App\Enum\ExportOrderStatus;
use App\Models\Accessory;
use App\Models\GateSpec;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;

class TestCommand extends Command
{
    protected $signature = 'app:test';

    protected $description = 'Commands description';

    public function handle(): void
    {
        $result = $this->testM(1 | 2);

        var_dump($result);
    }

    private function testM(int $number): int
    {
        return match ($number) {
            1 => 100,
            2 => 200,
        };
    }
}
