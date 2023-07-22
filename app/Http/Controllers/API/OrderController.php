<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use ShiftechAfrica\CodeGenerator\ShiftCodeGenerator;

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
            Order::query()->create([
                'orderNumber' => (new ShiftCodeGenerator())->generate(),
                'country_id' => $request->country_id,
                'product_id' => $request->product_id,
                'email' => $request->email,
                'quantity' => $request->quantity,
                'amount' => $request->amount,
            ]),
            Response::HTTP_CREATED
        );
    }
}
