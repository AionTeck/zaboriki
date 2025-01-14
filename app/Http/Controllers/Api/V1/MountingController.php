<?php

namespace App\Http\Controllers\Api\V1;

use App\UseCases\Queries\MountingQueryList;
use App\UseCases\Queries\MountingQueryOne;
use OpenApi\Attributes as OAT;

class MountingController extends BaseController
{
    #[OAT\Get(
        path: '/mountings',
        summary: 'Get all mountings',
        tags: ['Mountings'],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'OK'
            ),
        ]
    )]
    public function index(MountingQueryList $queryList)
    {
        return $queryList->handle();
    }

    #[OAT\Get(
        path: '/mountings/{id}',
        summary: 'Get mounting by ID',
        tags: ['Mountings'],
        parameters: [
            new OAT\PathParameter(
                name: 'id',
                description: 'Mounting ID',
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
    public function view(int $id, MountingQueryOne $queryOne)
    {
        return $queryOne->handle($id);
    }
}
