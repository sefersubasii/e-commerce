<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
        TokenMismatchException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($request->ajax() || $request->wantsJson()) {
            if ($e instanceof ModelNotFoundException) {
                return response()->json([
                    'errors' => 'Model not found',
                ], 404);
            }

            if ($e instanceof NotFoundHttpException) {
                return response()->json([
                    'errors' => 'Incorret route',
                ], 404);
            }
        }

        // // Redirect to a form. Here is an example of how I handle mine
        // if ($e instanceof \Illuminate\Session\TokenMismatchException) {
        //     return redirect($request->fullUrl())->with('csrf_error', "Güvenlik sebebiyle işlem engellendi.Lütfen tekrar deneyiniz.");
        // }

        if ($e instanceof NotFoundHttpException && $request->segment(1) == 'admin') {
            return response()->view('admin.404', [], 404);
        }

        return parent::render($request, $e);
    }
}
