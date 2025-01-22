<?php

namespace App\UseCases\Queries;

use App\Models\Accessory;
use App\Models\AccessorySpec;
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

        $specs = AccessorySpec::query()
            ->select([
                'id as spec_id',
                'dimension',
            ])
            ->where('accessory_id', '=', $accessory->id)
            ->get();

        $accessory->specs = $specs;

        return OperationResult::success($accessory);
    }
}
