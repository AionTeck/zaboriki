<?php

namespace App\Filament\Resources\SpecResource\Pages;

use App\Filament\Resources\SpecResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSpecs extends ListRecords
{
    protected static string $resource = SpecResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
