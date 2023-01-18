<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use LaravelMultipleGuards\Traits\FindGuard;

class OtpPass
{
    use FindGuard;

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse
     * @throws Exception
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        if ($this->findGuardType()->user()->isOtpVerified) {
            return $next($request);
        }
        return response()->redirectToRoute('otp.verification');
    }
}
