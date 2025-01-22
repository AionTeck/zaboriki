<?php

namespace App\Services\OrderExporter;

use App\Enum\ExportOrderStatus;
use App\Models\Order;
use App\Models\Settings;
use App\Services\CacheManager\CacheManager;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;

class OrderExportToPdf implements OrderExportInterface
{
    public function do(
        Collection $goodsCollection,
        Order $order,
        string $reportId,
    ): void
    {
        $formatter = new \NumberFormatter('ru_RU', \NumberFormatter::SPELLOUT);



        try {
            $data = $goodsCollection->toArray();

            $orderTotalSum =  $goodsCollection->sum('totalPrice');

            $orderTotalSumAsString = str(
                $formatter->format(
                    $orderTotalSum
                )
            )
                ->ucfirst()
                ->toString();

            $totalGoodsCount = $goodsCollection->sum('quantity');

            $orderNumber = $order->id;

            $settings = Settings::first();

            $documentText = $settings->executor_document_text;
            $documentPhone = $settings->executor_document_phone;

            $orderDetails = compact(
                'orderTotalSum',
                'orderTotalSumAsString',
                'totalGoodsCount',
                'orderNumber',
                'documentText',
                'documentPhone'
            );

            $pdf = Pdf::loadView('pdf.order_details', compact('data', 'orderDetails'));

            $filePath = \Storage::path('orders/' . $reportId . '.pdf');

            if (!file_exists(dirname($filePath))) {
                mkdir(dirname($filePath), 0755, true);
            }

            $pdf->save($filePath);

            CacheManager::editCache($reportId, [
                'pdf_status' => ExportOrderStatus::PdfSuccess->value,
                'pdf_path' => $filePath
            ]);
        } catch (\Throwable $e) {
            CacheManager::editCache($reportId, [
                'pdf_status' => ExportOrderStatus::PdfFailed->value,
                'pdf_message' => $e->getMessage()
            ]);
        }
    }
}
