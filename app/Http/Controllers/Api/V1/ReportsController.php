<?php

namespace App\Http\Controllers\Api\V1;

use App\Enum\ExportOrderStatus;
use OpenApi\Attributes as OAT;

class ReportsController extends BaseController
{

    #[OAT\Get(
        path: '/reports/{report_id}/status',
        summary: 'Get report status',
        tags: ['Reports'],
        parameters: [
            new OAT\PathParameter(
                name: 'report_id',
                description: 'Report ID',
                required: false,
                schema: new OAT\Schema(type: 'string')
            ),
        ],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'OK'
            ),
        ]
    )]
    public function checkExportOrderStatus(string $report_id)
    {
        $cache = \Cache::get($report_id);

        $status = $cache['status'];

        if (array_key_exists('pdf_status', $cache)) {
            $status = $cache['pdf_status'] === ExportOrderStatus::PdfSuccess->value ? 'success' : 'pending';
            $filePath = $cache['pdf_path'];
        }

        return response()->json([
            'status' => $status,
        ]);
    }
}
