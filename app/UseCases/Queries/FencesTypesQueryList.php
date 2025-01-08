<?php

namespace App\UseCases\Queries;

use App\Models\FenceType;
use Thumbrise\Toolkit\Opresult\OperationResult;
use function PHPUnit\Framework\exactly;

class FencesTypesQueryList
{
    public function handle(): OperationResult
    {
        $fenceTypes = FenceType::query()
            ->select([
                'id',
                'name'
            ])
            ->whereHas('fences')
            ->get();

        return OperationResult::success($fenceTypes);
    }
}
