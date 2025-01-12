<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MountingResource\Pages;
use App\Models\Mounting;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MountingResource extends Resource
{
    protected static ?string $model = Mounting::class;

    protected static ?string $slug = 'mountings';

    protected static ?string $modelLabel = 'Вариант монтажа';

    protected static ?string $pluralModelLabel = 'Варианты монтажа';

    protected static bool $hasTitleCaseModelLabel = false;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->translateLabel(),

                TextInput::make('price')
                    ->required()
                    ->integer()
                    ->minValue(0)
                    ->translateLabel(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),

                TextColumn::make('price')
                    ->translateLabel(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMountings::route('/'),
            'create' => Pages\CreateMounting::route('/create'),
            'edit' => Pages\EditMounting::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }
}
