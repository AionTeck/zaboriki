<?php

namespace App\Services\OrderExporter;

use App\Enum\ExportOrderStatus;
use App\Export\OrderDetailsExport;
use App\Models\Order;
use App\Services\CacheManager\CacheManager;
use App\Services\OrderExporter\OrderExportInterface;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;

class OrderExportToExcel implements OrderExportInterface
{

    public function do(
        Collection $goodsCollection,
        Order $order,
        string $reportId
    ): void
    {
        try {
            $filePath = 'orders/' . $order->client->id . '/' . $reportId . '.xlsx';

            if (!file_exists(dirname($filePath))) {
                mkdir(dirname($filePath), 0755, true);
            }

            Excel::store(new OrderDetailsExport($goodsCollection), $filePath, 'public');

            $order->update([
                'file_path' => $filePath
            ]);

            CacheManager::editCache($reportId, [
                'excel_status' => ExportOrderStatus::ExcelSuccess->value,
                'excel_path' => $filePath
            ]);
        } catch (\Throwable $e) {
            CacheManager::editCache($reportId, [
                'excel_status' => ExportOrderStatus::ExcelFailed->value,
                'excel_message' => $e->getMessage(),
            ]);
        }
    }
}
