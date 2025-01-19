<?php

namespace App\UseCases\Queries;

use App\Domain\Contexts\Fence\FenceDomainQueryUniqueList;
use App\Models\FenceSpec;
use App\Models\GateSpec;
use Illuminate\Database\Eloquent\Builder;
use Thumbrise\Toolkit\Opresult\OperationResult;

class FenceSpecQueryUniqueList
{
    public function handle(FenceDomainQueryUniqueList $data): OperationResult
    {
        $fenceSpecs = FenceSpec::query()
            ->select([
                'fence_specs.id as spec_id',
                'fence_specs.height',
                'fence_specs.value'
            ])
            ->whereHas('fence', function (Builder $query) use ($data) {
                $query->where('type_id', $data->typeId);
            })
            ->distinct()
            ->get();

        return OperationResult::success($fenceSpecs);
    }
}
