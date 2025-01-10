<?php

namespace App\UseCases\Queries;

use App\Domain\Contexts\Fence\FenceDomainQueryList;
use App\Models\Fence;
use Illuminate\Database\Eloquent\Builder;
use Thumbrise\Toolkit\Opresult\OperationResult;

class FencesQueryList
{
    public function handle(FenceDomainQueryList $data): OperationResult
    {
        $fencesList = Fence::query()
            ->select([
                'id',
                'name'
            ])
            ->when($data->typeId, function (Builder $query) use ($data) {
                $query->whereHas('type', function (Builder $query) use ($data) {
                    $query->where('fence_types.id', $data->typeId);
                });
            })
            ->get();

        return OperationResult::success($fencesList);
    }
}
