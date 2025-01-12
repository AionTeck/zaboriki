<?php

namespace App\UseCases\Queries;

use App\Models\Mounting;
use Thumbrise\Toolkit\Opresult\OperationResult;

class MountingQueryList
{
    public function handle(): OperationResult
    {
        $mountingList = Mounting::query()
            ->select([
                'id',
                'name'
            ])
            ->get();

        return OperationResult::success($mountingList);
    }
}
