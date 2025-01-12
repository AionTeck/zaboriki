<?php

namespace App\Filament\Resources\MountingResource\Pages;

use App\Filament\Resources\MountingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMounting extends EditRecord
{
    protected static string $resource = MountingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
