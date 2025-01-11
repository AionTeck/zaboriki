<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GateResource\Pages;
use App\Models\Gate;
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

class GateResource extends Resource
{
    protected static ?string $model = Gate::class;

    protected static ?string $slug = 'gates';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Ворота';

    protected static ?string $pluralModelLabel = 'Ворота';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->translateLabel()
                    ->columnSpanFull()
                    ->required(),

                Select::make('type_id')
                    ->translateLabel()
                    ->relationship('type', 'name')
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required(),
                    ])
                    ->helperText('К примеру: Распашной или Откатной'),

                Repeater::make('specs')
                    ->translateLabel()
                    ->columnSpanFull()
                    ->relationship('specs')
                    ->minItems(1)
                    ->schema([
                        TextInput::make('width')
                            ->translateLabel()
                            ->required()
                            ->numeric(),
                        TextInput::make('height')
                            ->translateLabel()
                            ->required()
                            ->numeric(),
                        TextInput::make('price')
                            ->translateLabel()
                            ->required()
                            ->numeric(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
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
            'index' => Pages\ListGates::route('/'),
            'create' => Pages\CreateGate::route('/create'),
            'edit' => Pages\EditGate::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }
}
