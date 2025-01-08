<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\UseCases\Queries\FencesTypesQueryList;

class FenceController extends Controller
{
    public function getTypes(FencesTypesQueryList $typesQueryList)
    {
        return $typesQueryList->handle();
    }
}
