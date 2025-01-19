<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Contexts\Calculate\CalculateDomainCommandPrepareData;
use App\Jobs\CalculateOrderJob;
use Illuminate\Http\Request;
use OpenApi\Attributes as OAT;

class Calculations extends BaseController
{
    public function getDataForPrepareOrder(Request $request)
    {
        $data = CalculateDomainCommandPrepareData::from($request);

        dispatch(new CalculateOrderJob($data));

        return response()->json(['status' => 'ok']);
    }

    #[OAT\Get(
        path: '/calculations/{report_id}/download-report',
        summary: 'Get report file',
        tags: ['Calculations'],
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
    public function downloadExportFile(string $report_id)
    {
        $cache = \Cache::get($report_id);

        $filePath = $cache['pdf_path'];

        \Cache::forget($report_id);

        return response()->download($filePath)->deleteFileAfterSend();
    }
}
