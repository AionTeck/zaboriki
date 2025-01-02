<?php

namespace App\Filament\Resources\FenceResource\Pages;

use App\Filament\Resources\FenceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFences extends ListRecords
{
    protected static string $resource = FenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
