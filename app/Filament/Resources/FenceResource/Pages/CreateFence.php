<?php

namespace App\Filament\Resources\FenceResource\Pages;

use App\Filament\Resources\FenceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFence extends CreateRecord
{
    protected static string $resource = FenceResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
