<?php

namespace App\Exceptions;

use App\Traits\NodeResponse;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use PDOException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use NodeResponse;

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        if (request()->is('api/*')) {
            $this->renderable(function (Throwable $exception, $request) {
                if ($exception instanceof HttpException) {
                    $code = $exception->getStatusCode();
                    $message = Response::$statusTexts[$code];

                    return $this->errorResponse($message, $code);
                }

                if ($exception instanceof ModelNotFoundException) {
                    $model = Str::lower(class_basename($exception->getModel()));
                    return $this->errorResponse("No instance of {$model} was found.", Response::HTTP_NOT_FOUND);
                }

                if ($exception instanceof AuthorizationException) {
                    return $this->errorResponse($exception->getMessage(), Response::HTTP_FORBIDDEN);
                }

                if ($exception instanceof AuthenticationException) {
                    return $this->errorResponse($exception->getMessage(), Response::HTTP_UNAUTHORIZED);
                }

                if ($exception instanceof ValidationException) {
                    return $this->errorResponse($exception->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
                }

                if ($exception instanceof QueryException) {
                    return $this->errorResponse($exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
                }

                if ($exception instanceof RelationNotFoundException) {
                    return $this->errorResponse($exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
                }

                if ($exception instanceof PDOException) {
                    return $this->errorResponse($exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
                }

                if ($exception instanceof ClientException) {
                    return $this->errorResponse($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
                }

                if ($exception instanceof ServerException) {
                    return $this->errorResponse($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
                }

                // check if debugging is allowed
                if (env('APP_DEBUG', false)) {
                    return parent::render($request, $exception);
                }

                Log::error($exception->getMessage());
                return $this->errorResponse('Unexpected error. Try later', Response::HTTP_INTERNAL_SERVER_ERROR);
            });
        }
    }
}
