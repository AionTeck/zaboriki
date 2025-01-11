<?php

namespace App\Console\Commands;

use App\Enum\AccessoryableType;
use App\Models\Accessory;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;

class TestCommand extends Command
{
    protected $signature = 'app:test';

    protected $description = 'Command description';

    public function handle(): void
    {
        var_dump(AccessoryableType::toArray());
    }
}
