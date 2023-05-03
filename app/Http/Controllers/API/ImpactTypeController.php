<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ImpactType;
use Illuminate\Http\JsonResponse;

class ImpactTypeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        return $this->successResponse(
            ImpactType::query()
                ->latest()
                ->get()
        );
    }
}
