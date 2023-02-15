<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use Illuminate\Http\JsonResponse;

class AdController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param string|null $countryId
     * @param int $limit
     * @return JsonResponse
     */
    public function __invoke(string $countryId = null, int $limit = 10): JsonResponse
    {
        return $this->successResponse(
            Ad::query()
                ->with([
                    'country',
                    'media'
                ])
                ->latest()
                ->orWhereIn('country_id', [$countryId])
                ->limit($limit)
                ->get()
        );
    }
}
