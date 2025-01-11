<?php

namespace App\UseCases\Queries;

use App\Models\FenceType;
use function PHPUnit\Framework\exactly;
use Thumbrise\Toolkit\Opresult\OperationResult;

class FencesTypesQueryList
{
    public function handle(): OperationResult
    {
        $fenceTypes = FenceType::query()
            ->select([
                'id',
                'name',
            ])
            ->whereHas('fences')
            ->get();

        return OperationResult::success($fenceTypes);
    }
}
