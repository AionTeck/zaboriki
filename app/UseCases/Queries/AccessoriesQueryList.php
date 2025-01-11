<?php

namespace App\UseCases\Queries;

use App\Domain\Contexts\Accessories\AccessoriesDomainQueryList;
use App\Models\Accessory;
use Illuminate\Database\Eloquent\Builder;
use Thumbrise\Toolkit\Opresult\OperationResult;

class AccessoriesQueryList
{
    public function handle(AccessoriesDomainQueryList $data): OperationResult
    {
        $accessory = Accessory::query()
            ->select([
                'id',
                'name',
            ])
            ->when($data->accessoriableType, function (Builder $query) use ($data) {
                $query->whereHas('accessoryables', function (Builder $query) use ($data) {
                    $query->where(
                        'accessoryables.accessoryable_type',
                        '=',
                        $data->accessoriableType->getModel());
                });
            })
            ->get();

        return OperationResult::success($accessory);
    }
}
