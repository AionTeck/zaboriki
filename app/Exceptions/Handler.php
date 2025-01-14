<?php

namespace App\Exceptions;

use App\Core\Error;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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

        $this->renderable(function (ValidationException $e, Request $request) {
            $validationErrors = $e->getMessage();

            $opResult = OperationResult::error($validationErrors, Error::INVALID_INPUT);

            $response = $opResult->toResponse($request);

            $response->setStatusCode(422);

            return $response;
        });

        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            $validationErrors = $e->getMessage();

            $opResult = OperationResult::error($validationErrors, Error::NOT_FOUND);

            $response = $opResult->toResponse($request);

            $response->setStatusCode(404);

            return $response;
        });
    }
}
