<?php

namespace App\Filament\Resources\AccessoryResource\Pages;

use App\Filament\Resources\AccessoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EditAccessory extends EditRecord
{
    protected static string $resource = AccessoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $entityBindings = $data['entity_bindings'] ?? [];

        DB::table('accessoryables')
            ->where('accessory_id', $record->id)
            ->delete();

        foreach ($entityBindings as $binding) {
            if (array_key_exists('entity_ids', $binding) && $binding['entity_ids']) {
                foreach ($binding['entity_ids'] as $entityId) {
                    DB::table('accessoryables')->insert([
                        'accessory_id' => $record->id,
                        'accessoryable_type' => $binding['entity_type'],
                        'accessoryable_id' => $entityId ?? null,
                    ]);
                }
            } else {
                    DB::table('accessoryables')->insert([
                        'accessory_id' => $record->id,
                        'accessoryable_type' => $binding['entity_type'],
                        'accessoryable_id' => null,
                    ]);
            }
        }
        unset($record->entity_bindings);

        $record->update($data);

        return $record;
    }
}
