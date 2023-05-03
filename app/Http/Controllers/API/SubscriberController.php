<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubscribeRequest;
use App\Models\Subscriber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class SubscriberController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param SubscribeRequest $request
     * @return JsonResponse
     */
    public function __invoke(SubscribeRequest $request): JsonResponse
    {
        return $this->successResponse(
            Subscriber::query()->create($request->validated()),
            Response::HTTP_CREATED
        );
    }
}
