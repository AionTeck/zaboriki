<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\UseCases\Queries\AboutQueryOne;
use OpenApi\Attributes as OAT;

class AboutController extends BaseController
{

    #[OAT\Get(
        path: '/about',
        summary: 'Get about info',
        tags: ['About'],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'OK'
            ),
        ]
    )]
    public function index(AboutQueryOne $queryOne)
    {
        return $queryOne->handle();
    }
}
