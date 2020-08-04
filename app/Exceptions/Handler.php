<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($this->isHttpException($exception)) {
            $request->headers->set('Accept', 'application/json');
            if (request()->expectsJson()) {
                if ($exception instanceof ModelNotFoundException) {
                    return response()->json([
                        'error' => 'Resource not found.'
                    ], 404);
                }
            
                if ($exception instanceof NotFoundHttpException) {
                    return response()->json([
                        'error' => 'Route not found.'
                    ], 404);
                }
            
                if ($exception instanceof MethodNotAllowedHttpException) {
                    return response()->json([
                        'error' => 'Method not allowed.'
                    ], 405);
                }
                if ($exception instanceof UnauthorizedHttpException) {
                    return response()->json([
                        'error' => $exception->getMessage()
                    ], $exception->getStatusCode());
                }
                
            }
        }
        return parent::render($request, $exception);
    }
}
