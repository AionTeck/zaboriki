<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Spatie\LaravelData\Exceptions\CannotCastData;
use Throwable;
use Thumbrise\Toolkit\Opresult\OperationResult;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (ValidationException $e, $request) {
            $validationErrors = $e->getMessage();

            $opResult = OperationResult::error($validationErrors, 422);

            $response = $opResult->toResponse($request);

            $response->setStatusCode(422);

            return $response;
        });
    }
}
