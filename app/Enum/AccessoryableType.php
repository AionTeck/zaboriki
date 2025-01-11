<?php

namespace App\Enum;

use App\Models\Fence;
use App\Models\Gate;
use App\Traits\HasTranslatedEnumLabels;

enum AccessoryableType: string
{
    use HasTranslatedEnumLabels;

    case Gate = 'gate';
    case Fence = 'fence';

    public function getModel(): string
    {
        return match ($this) {
            self::Gate => Gate::class,
            self::Fence => Fence::class,
        };
    }

    public static function toArray(): array
    {
        return array_map(fn(self $enum) => $enum->value, self::cases());
    }

    public static function getModelsAsArray(): array
    {
        return array_reduce(
            self::cases(),
            fn ($accumulate, $enum) => $accumulate + [$enum->getModel($enum) => $enum->label()],
            []
        );
    }
}
