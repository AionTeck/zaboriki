<?php

namespace App\UseCases\Queries;

use App\Models\Fence;
use App\Models\FenceCombination;
use App\Models\FenceSpec;
use Illuminate\Database\Query\JoinClause;
use Thumbrise\Toolkit\Opresult\OperationResult;

class FenceQueryOneWithSpecs
{
    public function handle(int $id): OperationResult
    {
        $fence = Fence::query()
            ->select([
                'id',
                'name',
            ])
            ->firstOrFail();

        $specs = FenceSpec::query()
            ->select([
                'value',
                'price'
            ])
            ->where('fence_id', '=', $fence->id)
        ;

        $fence->specs = $specs->get();

        return OperationResult::success($fence);
    }
}
