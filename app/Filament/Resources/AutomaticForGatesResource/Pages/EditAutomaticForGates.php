<?php

namespace App\Filament\Resources\AutomaticForGatesResource\Pages;

use App\Filament\Resources\AutomaticForGatesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAutomaticForGates extends EditRecord
{
    protected static string $resource = AutomaticForGatesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
