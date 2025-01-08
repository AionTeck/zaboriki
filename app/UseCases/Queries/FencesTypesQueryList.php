<?php

namespace App\UseCases\Queries;

use App\Models\FenceType;

class FencesTypesQueryList
{
    public function handle()
    {
        $fenceTypes = FenceType::query()
            ->select([
                'id',
                'name'
            ])
            ->whereHas('fences')
            ->get();
    }
}
