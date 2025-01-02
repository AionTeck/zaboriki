<?php

namespace App\Filament\Resources\FenceResource\Pages;

use App\Filament\Resources\FenceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFence extends EditRecord
{
    protected static string $resource = FenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
