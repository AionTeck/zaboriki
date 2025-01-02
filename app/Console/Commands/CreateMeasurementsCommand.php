<?php

namespace App\Console\Commands;

use App\Models\Measurement;
use Illuminate\Console\Command;

class CreateMeasurementsCommand extends Command
{
    protected $signature = 'create:measurements';

    protected $description = 'This command creating base measurements';

    public function handle(): void
    {
        $measurements = [
            [
                'name' => 'м.п.',
            ],
            [
                'name' => 'шт.',
            ],
            [
                'name' => 'рулон',
            ],
            [
                'name' => 'лист',
            ],
            [
                'name' => 'комплект',
            ],
        ];

        Measurement::insert($measurements);
    }
}
