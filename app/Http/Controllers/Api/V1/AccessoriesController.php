<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Contexts\Accessories\AccessoriesDomainQueryList;
use App\Enum\AccessoryableType;
use App\Http\Controllers\Controller;
use App\UseCases\Queries\AccessoriesQueryList;
use App\UseCases\Queries\AccessoriesQueryOne;
use Illuminate\Http\Request;
use OpenApi\Attributes as OAT;

class AccessoriesController extends Controller
{
    #[OAT\Get(
        path: '/accessories',
        summary: 'Get all accessories',
        tags: ['Accessories'],
        parameters: [
            new OAT\QueryParameter(
                name: 'accessoriableType',
                description: 'Accessoriable type for accessories',
                required: false,
                schema: new OAT\Schema(enum: AccessoryableType::class)
            )
        ],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'OK'
            ),
        ]
    )]
    public function index(Request $request, AccessoriesQueryList $queryList)
    {
        $input = AccessoriesDomainQueryList::from($request);

        return $queryList->handle($input);
    }

    #[OAT\Get(
        path: '/accessories/{id}',
        summary: 'Get accessory by ID',
        tags: ['Accessories'],
        parameters: [
            new OAT\PathParameter(
                name: 'id',
                description: 'Accessoriable ID',
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
    public function show(int $id, AccessoriesQueryOne $queryOne)
    {
        return $queryOne->handle($id);
    }
}
