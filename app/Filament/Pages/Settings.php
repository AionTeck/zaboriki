<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Settings extends Page
{
    public array $data = [];
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.settings';
}
