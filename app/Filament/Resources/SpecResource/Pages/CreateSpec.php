<?php

namespace App\Filament\Resources\SpecResource\Pages;

use App\Filament\Resources\SpecResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSpec extends CreateRecord
{
    protected static string $resource = SpecResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
