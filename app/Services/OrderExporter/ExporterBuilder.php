<?php

namespace App\Services\OrderExporter;

use App\Enum\ExportOrderType;

class ExporterBuilder
{
    public function build(ExportOrderType $type): OrderExportInterface
    {
        return match ($type) {
            ExportOrderType::PDF => new OrderExportToPdf(),
            ExportOrderType::EXCEL => new OrderExportToExcel(),
        };
    }
}
