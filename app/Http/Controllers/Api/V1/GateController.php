<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Contexts\Gate\GateDomainQueryList;
use App\UseCases\Queries\GateQueryList;
use App\UseCases\Queries\GateQueryOne;
use App\UseCases\Queries\GatesTypesQueryList;
use Illuminate\Http\Request;
use OpenApi\Attributes as OAT;

class GateController extends BaseController
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

    #[OAT\Get(
        path: '/gates/{id]',
        summary: 'Get gate by ID',
        tags: ['Gates'],
        parameters: [
            new OAT\PathParameter(
                name: 'id',
                description: 'Gate ID',
                required: true,
                schema: new OAT\Schema(type: 'integer')
            )
        ],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'OK'
            ),
        ]
    )]
    public function show(int $id, GateQueryOne $queryOne)
    {
        return $queryOne->handle($id);
    }
}
