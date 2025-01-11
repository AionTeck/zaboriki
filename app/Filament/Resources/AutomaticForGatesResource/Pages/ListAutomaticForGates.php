<?php

namespace App\Filament\Resources\AutomaticForGatesResource\Pages;

use App\Filament\Resources\AutomaticForGatesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAutomaticForGates extends ListRecords
{
    protected static string $resource = AutomaticForGatesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
