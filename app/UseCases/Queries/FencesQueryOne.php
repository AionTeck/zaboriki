<?php

namespace App\UseCases\Queries;

use App\Core\Error;
use App\Models\Fence;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Thumbrise\Toolkit\Opresult\OperationResult;

class FencesQueryOne
{
    public function handle(int $id): OperationResult
    {
        $fence = Fence::query()
            ->select([
                'id',
                'name',
            ])
            ->where('id', '=', $id)
            ->firstOrFail();

        return OperationResult::success($fence);
    }
}
