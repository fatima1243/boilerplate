<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        // Check if the request expects JSON
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        // Redirect based on the guard or default behavior
        $guard = $exception->guards()[0] ?? null;

        switch ($guard) {
            case 'driver':
                $loginRoute = route('driver.login');
                break;
            case 'recruiter':
                $loginRoute = route('recruiter.login');
                break;
            default:
                $loginRoute = route('login'); // Default login route
        }

        return redirect()->guest($loginRoute);
    }
}
