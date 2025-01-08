<?php

namespace App\Enum;

use App\Traits\HasTranslatedEnumLabels;

enum SpecType: string
{
    use HasTranslatedEnumLabels;

    case HEIGHT = 'height';
    case WIDTH = 'width';
    case COLOR = 'color';
}
