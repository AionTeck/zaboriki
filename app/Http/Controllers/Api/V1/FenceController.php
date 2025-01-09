<?php

namespace App\Http\Controllers\Api\V1;

use App\Data\FenceRequest;
use App\UseCases\Queries\FencesQueryList;
use App\UseCases\Queries\FencesTypesQueryList;
use Illuminate\Http\Request;
use OpenApi\Attributes as OAT;

class FenceController extends BaseController
{
    #[OAT\Get(
        path: '/fences/types',
        summary: 'Get all fence types',
        tags: ['Fences'],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'OK'
            ),
        ]
    )]
    public function getTypes(FencesTypesQueryList $typesQueryList)
    {
        return $typesQueryList->handle();
    }

    #[OAT\Get(
        path: '/fences',
        summary: 'Get all fences',
        tags: ['Fences'],
        parameters: [
            new OAT\QueryParameter(
                name: 'typeId',
                description: 'Fence type ID',
                required: false
            )
        ]
    )]
    public function index(Request $request, FencesQueryList $queryList)
    {
        $data = FenceRequest::from($request);

        return $queryList->handle($data);
    }
}
