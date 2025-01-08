<?php

namespace App\Traits;

use BackedEnum;
use Illuminate\Support\Facades\Lang;

/**
 * @mixin BackedEnum
 */
trait HasTranslatedEnumLabels
{
    public function label(): string
    {
        return Lang::get("$this->value");
    }

    public static function toTranslatedArray(): array
    {
        return array_reduce(
            self::cases(),
            fn ($accumulate, $enum) => $accumulate + [$enum->value => $enum->label()],
            []
        );
    }
}
