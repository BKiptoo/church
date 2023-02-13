<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\Subscriber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param OrderRequest $request
     * @return JsonResponse
     */
    public function __invoke(OrderRequest $request): JsonResponse
    {
        return $this->successResponse(
            Order::query()->create($request->validated()),
            Response::HTTP_CREATED
        );
    }
}
