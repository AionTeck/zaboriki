<?php

namespace App\Filament\Resources\MountingResource\Pages;

use App\Filament\Resources\MountingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMountings extends ListRecords
{
    protected static string $resource = MountingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
