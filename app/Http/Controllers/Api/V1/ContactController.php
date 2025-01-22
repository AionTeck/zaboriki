<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Contexts\Contact\ContactsDomainCommandSendRequest;
use App\UseCases\Commands\ContactsCommandSendRequest;
use Illuminate\Http\Request;
use OpenApi\Attributes as OAT;

class ContactController extends BaseController
{
    #[OAT\Post(
        path: '/contact',
        summary: 'Send contact request',
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\MediaType(
                mediaType: 'application/json',
                schema: new OAT\Schema(
                    required: ['userId', 'message'],
                    properties: [
                        new OAT\Property(
                            property: 'userId',
                            description: 'Telegram user_id',
                            type: 'string',
                        ),
                        new OAT\Property(
                            property: 'message',
                            description: "Client's message",
                            type: 'string',
                        ),
                    ]
                )
            )
        ),
        tags: ['Contact'],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'OK'
            ),
        ]
    )]
    public function index(Request $request, ContactsCommandSendRequest $commandSendRequest)
    {
        $input = ContactsDomainCommandSendRequest::from($request);

        $opResult = $commandSendRequest->handle($input);

        if ($opResult->isError()) {
            return response($opResult->error->toArray(), 400);
        }

        return $opResult;
    }
}
