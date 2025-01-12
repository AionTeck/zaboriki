<?php

namespace App\Filament\Resources;

use App\Enum\AccessoryableType;
use App\Filament\Resources\AccessoryResource\Pages;
use App\Models\Accessory;
use Closure;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AccessoryResource extends Resource
{
    protected static ?string $model = Accessory::class;

    protected static ?string $slug = 'accessories';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Аксессуар';

    protected static ?string $pluralModelLabel = 'Аксессуары';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->translateLabel()
                    ->required(),

                Select::make('measurement_id')
                    ->translateLabel()
                    ->relationship('measurement', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Repeater::make('entity_bindings')
                    ->label('Привязка к сущностям')
                    ->schema([
                        Select::make('entity_type')
                            ->label('Тип сущности')
                            ->options(AccessoryableType::getModelsAsArray())
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                                if($state !== $old) {
                                    $set('entity_ids', []);
                                }
                            }),

                        Select::make('entity_ids')
                            ->label('Конкретная запись')
                            ->options(function (Get $get) {
                                $type = $get('entity_type');
                                if ($type) {
                                    return $type::pluck('name', 'id');
                                }
                                return [];
                            })
                            ->multiple()
                            ->markAsRequired(fn (Get $get) => $get('is_universal'))
                            ->searchable()
                            ->nullable(),
                    ])
                    ->afterStateHydrated(function (Get $get, Set $set) {

                        $accessory = Accessory::firstWhere('id', '=', $get('id'));

                        if ($accessory) {
                            $bindings = DB::table('accessoryables')
                                ->where('accessoryables.accessory_id', '=', $accessory->id)
                                ->get();

                            $groupedBindings = $bindings->groupBy('accessoryable_type');

                            $counter = 0;

                            $groupedBindings->each(function ($bindings, $type) use ($set, &$counter) {
                                $set("entity_bindings.$counter.entity_type", $type);

                                $accessoryable_ids = [];

                                foreach ($bindings as $binding) {
                                    if (!$binding->accessoryable_id) {
                                        break;
                                    }

                                    $accessoryable_ids[] = $binding->accessoryable_id;
                                }

                                $set("entity_bindings.$counter.entity_ids", $accessoryable_ids);

                                $counter++;
                            });
                        }
                    })
                    ->maxItems(count(AccessoryableType::getModelsAsArray()))
                    ->rules([
                        fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                            $array = $get('entity_bindings.*.entity_type');

                            if (count($array) !== count(array_unique($array))) {
                                $fail("Должны быть уникальные типы сущности");
                            }
                        },
                    ])
                    ->hidden(fn(Get $get) => !$get('id'))
                    ->columnSpanFull(),

                Repeater::make('specs')
                    ->translateLabel()
                    ->relationship('specs')
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('dimension')
                            ->translateLabel()
                            ->required()
                            ->helperText('Указываются параметры в мм. К примеру: 10x10x2.5'),
                        TextInput::make('price')
                            ->translateLabel()
                            ->required()
                            ->numeric()
                            ->minValue(0),
                    ])
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

                TextColumn::make('measurement.name')
                    ->searchable()
                    ->sortable()
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
            'index' => Pages\ListAccessories::route('/'),
            'create' => Pages\CreateAccessory::route('/create'),
            'edit' => Pages\EditAccessory::route('/{record}/edit'),
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
