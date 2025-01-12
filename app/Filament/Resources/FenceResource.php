<?php

namespace App\Filament\Resources;

use App\Enum\SpecType;
use App\Filament\Resources\FenceResource\Pages;
use App\Models\Fence;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\HasManyRepeater;
use Filament\Forms\Components\Hidden;
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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class FenceResource extends Resource
{
    protected static ?string $model = Fence::class;
    protected static ?string $slug = 'fences';
    protected static ?string $navigationLabel = 'Заборы';
    protected static ?string $modelLabel = 'Забор';
    protected static ?string $pluralLabel = 'Заборы';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->translateLabel(),

                Select::make('measurement_id')
                    ->required()
                    ->translateLabel()
                    ->relationship('measurement', 'name')
                    ->preload()
                    ->searchable(),

                Select::make('type')
                    ->translateLabel()
                    ->required()
                    ->relationship('type', 'name')
                    ->createOptionForm([
                        TextInput::make('name')
                            ->translateLabel()
                            ->required()
                    ]),

                Repeater::make('colors')
                    ->relationship('colors')
                    ->translateLabel()
                    ->columnSpanFull()
                    ->minItems(1)
                    ->schema([
                        Hidden::make('spec_type')
                            ->default(SpecType::COLOR->value),

                        ColorPicker::make('value')
                            ->label('Цвет')
                            ->required(),
                    ])
                    ->addActionLabel('Добавить цвет'),

                Repeater::make('specs')
                    ->relationship('specs')
                    ->translateLabel()
                    ->columnSpanFull()
                    ->minItems(1)
                    ->schema([
                        Select::make('spec_type')
                            ->options(function () {
                                $types = SpecType::toTranslatedArray();

                                unset($types['color']);

                                return $types;
                            })
                            ->translateLabel()
                            ->required(),

                        TextInput::make('value')
                            ->translateLabel()
                            ->required(),

                        TextInput::make('price')
                            ->translateLabel()
                            ->required()
                            ->numeric()
                    ])
                    ->addActionLabel('Добавить комбинацию'),
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

                TextColumn::make('measurement.name')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('type.name')
                    ->translateLabel()
                    ->sortable()
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
            'index' => Pages\ListFences::route('/'),
            'create' => Pages\CreateFence::route('/create'),
            'edit' => Pages\EditFence::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['measurement']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'measurement.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->measurement) {
            $details['Measurement'] = $record->measurement->name;
        }

        return $details;
    }
}
