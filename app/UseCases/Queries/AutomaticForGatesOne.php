<?php

namespace App\UseCases\Queries;

use App\Models\AutomaticForGate;
use Thumbrise\Toolkit\Opresult\OperationResult;

class AutomaticForGatesOne
{
    public function handle(int $id): OperationResult
    {
        $automaticForGate = AutomaticForGate::query()
            ->select([
                'id',
                'name',
            ])
            ->where('id', '=', $id)
            ->firstOrFail();

        return OperationResult::success($automaticForGate);
    }
}
