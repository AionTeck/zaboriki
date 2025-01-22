<?php

namespace App\Services\OrderExporter;

use App\Models\Order;
use Illuminate\Support\Collection;

interface OrderExportInterface
{
    public function do(
        Collection $goodsCollection,
        Order $order,
        string $reportId,
    ): void;
}
