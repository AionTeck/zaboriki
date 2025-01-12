<?php

namespace App\Filament\Resources\MountingResource\Pages;

use App\Filament\Resources\MountingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMounting extends CreateRecord
{
    protected static string $resource = MountingResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
