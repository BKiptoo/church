<?php

namespace App\Http\Middleware;

use App\Http\Controllers\SystemController;
use App\Traits\NodeResponse;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class APIFireWall
{
    use NodeResponse;

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return JsonResponse|RedirectResponse|Response|mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (!in_array($request->ip(), [
            '104.196.71.7',
            '172.217.170.211'
        ])) {
            SystemController::log([
                $request->ip()
            ], 'ips', 'ips');
            SystemController::log([
                $request->ip()
            ], 'client_ips', 'client_ips');
            SystemController::log([
                $request->host()
            ], 'host', 'host');
            SystemController::log([
                $request->httpHost()
            ], 'http_host', 'http_host');
//            return $this->errorResponse(
//                $request->ip() . ' un-known host.',
//                Response::HTTP_BAD_REQUEST
//            );
        }
        return $next($request);
    }
}
