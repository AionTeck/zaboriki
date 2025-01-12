<?php

namespace App\UseCases\Queries;

use App\Models\Accessory;
use Thumbrise\Toolkit\Opresult\OperationResult;

class AccessoriesQueryOne
{
    public function handle(int $id): OperationResult
    {
        $accessory = Accessory::query()
            ->select([
                'id',
                'name',
            ])
            ->where('id', '=', $id)
            ->firstOrFail();

        return OperationResult::success($accessory);
    }
}
