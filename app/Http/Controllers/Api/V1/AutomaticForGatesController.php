<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Contexts\AutomaticForGates\AutomaticForGatesDomainQueryList;
use App\UseCases\Queries\AutomaticForGatesOne;
use App\UseCases\Queries\AutomaticForGatesQueryList;
use Illuminate\Http\Request;
use OpenApi\Attributes as OAT;

class AutomaticForGatesController extends BaseController
{
    #[OAT\Get(
        path: '/automatic-for-gates',
        summary: 'Get all automatic for gates',
        tags: ['Automatic for gates'],
        parameters: [
            new OAT\QueryParameter(
                name: 'gateTypeId',
                description: 'Gate type ID',
                required: false,
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
    public function index(Request $request, AutomaticForGatesQueryList $queryList)
    {
        $input = AutomaticForGatesDomainQueryList::from($request);

        return $queryList->handle($input);
    }

    #[OAT\Get(
        path: '/automatic-for-gates/{id}',
        summary: 'Get automatic for gate',
        tags: ['Automatic for gates'],
        parameters: [
            new OAT\PathParameter(
                name: 'id',
                description: 'Automatic for gate ID',
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
    public function show(int $id, AutomaticForGatesOne $automaticForGatesOne)
    {
        return $automaticForGatesOne->handle($id);
    }
}
