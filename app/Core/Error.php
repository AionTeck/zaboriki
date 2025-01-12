<?php

namespace App\Core;

enum Error
{
    case NOT_FOUND;
    case FORBIDDEN;
    case INVALID_INPUT;
}
