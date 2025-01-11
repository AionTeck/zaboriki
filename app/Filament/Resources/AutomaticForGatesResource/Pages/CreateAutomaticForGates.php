<?php

namespace App\Filament\Resources\AutomaticForGatesResource\Pages;

use App\Filament\Resources\AutomaticForGatesResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAutomaticForGates extends CreateRecord
{
    protected static string $resource = AutomaticForGatesResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
