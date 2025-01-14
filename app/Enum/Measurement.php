<?php

namespace App\Enum;

use App\Traits\HasTranslatedEnumLabels;

enum Measurement: string
{
    use HasTranslatedEnumLabels;

    case LINEAR_METER = 'lm';
    case PIECE = 'pc';
    case ROLL = 'rl';
    case LIST = 'ls';
    case SET = 'st';
}
