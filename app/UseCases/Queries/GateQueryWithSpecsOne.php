<?php

namespace App\UseCases\Queries;

use App\Models\Gate;
use App\Models\GateSpec;
use Thumbrise\Toolkit\Opresult\OperationResult;

class GateQueryWithSpecsOne
{
    public function handle(int $id): OperationResult
    {
        $gate = Gate::query()
            ->select([
                'id',
                'name'
            ])
            ->where('id', '=', $id)
            ->firstOrFail();

        $specs = GateSpec::query()
            ->select([
                'id as spec_id',
                'value',
                'price'
            ])
            ->where('gate_id', '=', $gate->id)
            ->get();

        $gate->specs = $specs;

        return OperationResult::success($gate);
    }
}
