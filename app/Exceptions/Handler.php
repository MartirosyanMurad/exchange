<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * @inheritdoc
     * @throws Throwable
     */
    public function render($request, Throwable $exception): Response
    {
        if ($exception instanceof AuthenticationException) {
            if (strpos($request->getUri(), 'home')) {
                return new Response('{“status”: “ok”, “message”: “Login success”}', 200, [
                    'Content-Type' => 'application/json'
                ]);
            }
            return new Response('{“status”: “error”, “code”: 403, “message”: “Invalid token”}', 403, [
                'Content-Type' => 'application/json'
            ]);
        }

        return parent::render($request,  $exception);
    }
}
