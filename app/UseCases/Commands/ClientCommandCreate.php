<?php

namespace App\UseCases\Commands;

use App\Domain\Contexts\Client\ClientDomainCommandCreate;
use App\Models\Client;
use Thumbrise\Toolkit\Opresult\OperationResult;

class ClientCommandCreate
{
    public function handle(ClientDomainCommandCreate $data): OperationResult
    {
        try {
            Client::updateOrCreate(
                [
                    'telegram_id' => $data->telegramId
                ], [
                    'name' => $data->name,
                    'email' => $data->email,
                    'phone_number' => $data->phoneNumber,
                    'telegram_id' => $data->telegramId
                ]
            );

            return OperationResult::success();
        } catch (\Throwable $e) {
            return OperationResult::error($e->getMessage());
        }
    }
}
