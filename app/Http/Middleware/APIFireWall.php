<?php

namespace App\Http\Middleware;

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
     * @return JsonResponse|RedirectResponse|Response
     */
    public function handle(Request $request, Closure $next): Response|JsonResponse|RedirectResponse
    {
        if (!in_array($request->getHost(), ['104.196.71.7', '172.217.170.211'])) {
            return $this->errorResponse(
                $request->getHost() . ' un known host.',
                Response::HTTP_BAD_REQUEST
            );
        }
        return $next($request);
    }
}
