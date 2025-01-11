<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AutomaticForGatesResource\Pages;
use App\Models\AutomaticForGate;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AutomaticForGatesResource extends Resource
{
    protected static ?string $model = AutomaticForGate::class;

    protected static ?string $slug = 'automatic-for-gates';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Автоматика для ворот';

    protected static ?string $pluralModelLabel = 'Автоматика для ворот';

    protected static bool $hasTitleCaseModelLabel = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->translateLabel()
                    ->required(),

                Repeater::make('specs')
                    ->translateLabel()
                    ->columnSpanFull()
                    ->relationship('specs')
                    ->schema([
                        Select::make('gate_type_id')
                            ->translateLabel()
                            ->relationship('gateType', 'name'),
                        TextInput::make('price')
                            ->translateLabel()
                            ->numeric()
                            ->minValue(0),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('specs.gateType.name')
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
            'index' => Pages\ListAutomaticForGates::route('/'),
            'create' => Pages\CreateAutomaticForGates::route('/create'),
            'edit' => Pages\EditAutomaticForGates::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }
}
