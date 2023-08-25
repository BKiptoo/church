<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Coverage;
use Illuminate\Http\JsonResponse;

class CoverageController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param string $countryId
     * @param int $limit
     * @return JsonResponse
     */
    public function __invoke(string $countryId = '', int $limit = 10): JsonResponse
    {
        return $this->successResponse(
            Coverage::query()
                ->with([
                    'country',
                    'media'
                ])
                ->latest('updated_at')
                ->where(function ($query) use ($countryId) {
                    $query->orWhere('country_id', 'ilike', '%' . $countryId . '%');
                })
                ->limit($limit)
                ->get()
        );
    }
}
