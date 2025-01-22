<?php

namespace App\UseCases\Commands;

use App\Core\Error;
use App\Domain\Contexts\Contact\ContactsDomainCommandSendRequest;
use App\Mail\SendContactMail;
use App\Models\Client;
use App\Models\Settings;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Psr\Log\LoggerInterface;
use Thumbrise\Toolkit\Opresult\OperationResult;

class ContactsCommandSendRequest
{
    public function __construct(
        private readonly LoggerInterface $logger
    )
    {
    }

    /**
     * @param ContactsDomainCommandSendRequest $data
     * @return OperationResult
     * @throws ModelNotFoundException
     */
    public function handle(ContactsDomainCommandSendRequest $data): OperationResult
    {
        try {
            $emailTo = Settings::query()
                ->firstOrFail()
                ->request_email;

            $client = Client::query()
                ->where('telegram_id', '=', $data->userId)
                ->firstOrFail();

            \Mail::to($emailTo)
                ->send(new SendContactMail($client->phone_number, $data->message));

            return OperationResult::success();
        } catch (\Throwable $e) {
            $this->logger->error($e);
            return OperationResult::error("Возникла непредвиденная ошибка", Error::EMAIL_ERROR);
        }
    }
}
