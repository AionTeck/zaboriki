<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Contexts\Fence\FenceDomainQueryList;
use App\Domain\Contexts\Fence\FenceDomainQueryUniqueList;
use App\UseCases\Queries\FenceQueryOneWithSpecs;
use App\UseCases\Queries\FenceSpecQueryUniqueList;
use App\UseCases\Queries\FencesQueryList;
use App\UseCases\Queries\FencesQueryOne;
use App\UseCases\Queries\FencesTypesQueryList;
use Illuminate\Http\Request;
use OpenApi\Attributes as OAT;

class FenceController extends BaseController
{
    #[OAT\Get(
        path: '/fences/types/',
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
                required: false,
                schema: new OAT\Schema(type: 'integer')
            ),
            new OAT\QueryParameter(
                name: 'height',
                description: 'Fence height',
                required: false,
                schema: new OAT\Schema(type: 'float')
            ),
        ],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'OK'
            ),
        ]
    )]
    public function index(Request $request, FencesQueryList $queryList)
    {
        $data = FenceDomainQueryList::from($request);

        return $queryList->handle($data);
    }

    #[OAT\Get(
        path: '/fences/{id}',
        summary: 'Get fence by ID',
        tags: ['Fences'],
        parameters: [
            new OAT\PathParameter(
                name: 'id',
                description: 'Fence ID',
                required: true,
                schema: new OAT\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'OK'
            ),
        ]
    )]
    public function show(int $id, FencesQueryOne $queryGetOne)
    {
        return $queryGetOne->handle($id);
    }

    #[OAT\Get(
        path: '/fences/{id}/specs',
        summary: 'Get fence with specs by ID',
        tags: ['Fences'],
        parameters: [
            new OAT\PathParameter(
                name: 'id',
                description: 'Fence ID',
                required: true,
                schema: new OAT\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'OK'
            ),
        ]
    )]
    public function getSpecs(int $id, FenceQueryOneWithSpecs $specs)
    {
        return $specs->handle($id);
    }

    #[OAT\Get(
        path: '/fences/popular-specs',
        summary: 'Get fences popular specs',
        tags: ['Fences'],
        parameters: [
            new OAT\QueryParameter(
                name: 'typeId',
                description: 'Fence type ID',
                required: false,
                schema: new OAT\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'OK'
            ),
        ]
    )]
    public function getPopularSpecs(Request $request, FenceSpecQueryUniqueList $queryUniqueList)
    {
        $data = FenceDomainQueryUniqueList::from($request);

        return $queryUniqueList->handle($data);
    }
}
