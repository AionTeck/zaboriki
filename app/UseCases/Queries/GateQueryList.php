<?php

namespace App\UseCases\Queries;

use App\Domain\Contexts\Gate\GateDomainQueryList;
use App\Models\Gate;
use Illuminate\Database\Eloquent\Builder;
use Thumbrise\Toolkit\Opresult\OperationResult;

class GateQueryList
{
    public function handle(GateDomainQueryList $data): OperationResult
    {
        $gatesList = Gate::query()
            ->select([
                'id',
                'name',
            ])
            ->when($data->typeId, function (Builder $query) use ($data) {
                $query->whereHas('type', function (Builder $query) use ($data) {
                    $query->where('id', $data->typeId);
                });
            })
            ->get();

        return OperationResult::success($gatesList);
    }
}
