<?php

namespace App\UseCases\Queries;

use App\Domain\Contexts\Gate\GateDomainQueryList;
use App\Models\GateType;
use Thumbrise\Toolkit\Opresult\OperationResult;

class GatesTypesQueryList
{
    public function handle(): OperationResult
    {
        $typesList = GateType::query()
            ->select([
                'id',
                'name'
            ])
            ->whereHas('gates')
            ->get();

        return OperationResult::success($typesList);
    }
}
