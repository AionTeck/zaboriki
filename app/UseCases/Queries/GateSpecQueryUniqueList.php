<?php

namespace App\UseCases\Queries;

use App\Domain\Contexts\Fence\FenceDomainQueryUniqueList;
use App\Domain\Contexts\Gate\GateDomainQueryUniqueList;
use App\Models\GateSpec;
use Illuminate\Database\Eloquent\Builder;
use Thumbrise\Toolkit\Opresult\OperationResult;

class GateSpecQueryUniqueList
{
    public function handle(GateDomainQueryUniqueList $data): OperationResult
    {
        $gateSpecs = GateSpec::query()
            ->select([
                'id as spec_id',
                'height',
                'width',
            ])
            ->whereHas('gate', function (Builder $query) use ($data) {
                $query->where('gates.type_id', $data->typeId);
            })
            ->distinct()
            ->get();

        return OperationResult::success($gateSpecs);
    }
}
