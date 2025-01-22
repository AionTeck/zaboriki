<?php

namespace App\UseCases\Queries;

use App\Models\Settings;
use Thumbrise\Toolkit\Opresult\OperationResult;

class AboutQueryOne
{
    public function handle(): OperationResult
    {
        $aboutInfo = Settings::query()
            ->select([
                'about_image',
                'about_text'
            ])
            ->firstOrFail();

        $aboutInfo->about_image = \Storage::url($aboutInfo->about_image) ?? null;

        return OperationResult::success($aboutInfo);
    }
}
