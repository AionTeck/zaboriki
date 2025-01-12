<?php

namespace App\UseCases\Queries;

use App\Domain\Contexts\AutomaticForGates\AutomaticForGatesDomainQueryList;
use App\Models\AutomaticForGate;
use Illuminate\Database\Eloquent\Builder;
use Thumbrise\Toolkit\Opresult\OperationResult;

class AutomaticForGatesQueryList
{
    public function handle(AutomaticForGatesDomainQueryList $data): OperationResult
    {
        $automaticForGatesList = AutomaticForGate::query()
            ->select([
                'id',
                'name',
            ])
            ->when($data->gateTypeId, function (Builder $query) use ($data) {
                $query->whereHas('specs', function (Builder $query) use ($data) {
                    $query->where('gate_type_id', $data->gateTypeId);
                });
            })
            ->get();

        return OperationResult::success($automaticForGatesList);
    }
}
