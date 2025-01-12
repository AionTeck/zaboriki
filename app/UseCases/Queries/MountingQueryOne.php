<?php

namespace App\UseCases\Queries;

use App\Models\Mounting;
use Thumbrise\Toolkit\Opresult\OperationResult;

class MountingQueryOne
{
    public function handle(int $id): OperationResult
    {
        $mounting = Mounting::query()
            ->select([
                'id',
                'name',
            ])
            ->where('id', '=', $id)
            ->firstOrFail();

        return OperationResult::success($mounting);
    }
}
