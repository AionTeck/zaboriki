<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Contexts\Client\ClientDomainCommandCreate;
use App\Enum\AccessoryableType;
use App\Http\Controllers\Controller;
use App\UseCases\Commands\ClientCommandCreate;
use Illuminate\Http\Request;
use OpenApi\Attributes as OAT;

class ClientController extends Controller
{
    #[OAT\Post(
        path: '/clients',
        summary: 'Create client',
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\MediaType(
                mediaType: 'application/json',
                schema: new OAT\Schema(
                    required: ['name', 'telegram_id'],
                    properties: [
                        new OAT\Property(
                            property: 'name',
                            description: 'Client name',
                            type: 'string',
                        ),
                        new OAT\Property(
                            property: 'email',
                            description: 'Client email',
                            type: 'string',
                        ),
                        new OAT\Property(
                            property: 'phoneNumber',
                            description: 'Client phone',
                            type: 'string',
                        ),
                        new OAT\Property(
                            property: 'telegramId',
                            description: 'Client telegram_id',
                            type: 'string',
                        ),
                    ]
                )
            )
        ),
        tags: ['Client'],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'OK'
            ),
        ]
    )]
    public function create(Request $request, ClientCommandCreate $commandCreate)
    {
        $input = ClientDomainCommandCreate::from($request);

        return $commandCreate->handle($input);
    }
}
