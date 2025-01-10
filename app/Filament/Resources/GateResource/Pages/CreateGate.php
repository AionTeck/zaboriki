<?php

namespace App\Filament\Resources\GateResource\Pages;

use App\Filament\Resources\GateResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGate extends CreateRecord
{
    protected static string $resource = GateResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
