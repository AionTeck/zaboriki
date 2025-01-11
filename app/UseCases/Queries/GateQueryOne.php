<?php

namespace App\UseCases\Queries;

use App\Models\Gate;
use Thumbrise\Toolkit\Opresult\OperationResult;

class GateQueryOne
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

        return OperationResult::success($gate);
    }
}
