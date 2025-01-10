<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Contexts\Gate\GateDomainQueryList;
use App\Http\Controllers\Controller;
use App\Models\Gate;
use App\UseCases\Queries\GateQueryList;
use App\UseCases\Queries\GatesTypesQueryList;
use Illuminate\Http\Request;
use OpenApi\Attributes as OAT;

class GateController extends Controller
{
    #[OAT\Get(
        path: '/gates/types',
        summary: 'Get all gates types',
        tags: ['Gates'],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'OK'
            ),
        ]
    )]
    public function getTypes(GatesTypesQueryList $queryList)
    {
        return $queryList->handle();
    }

    #[OAT\Get(
        path: '/gates',
        summary: 'Get all gates',
        tags: ['Gates'],
        parameters: [
            new OAT\QueryParameter(
                name: 'typeId',
                description: 'Gate type ID',
                required: false
            )
        ],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'OK'
            ),
        ]
    )]
    public function index(Request $request, GateQueryList $queryList)
    {
        $input = GateDomainQueryList::from($request);

        return $queryList->handle($input);
    }
}
