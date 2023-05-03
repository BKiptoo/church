<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Office;
use Illuminate\Http\JsonResponse;

class OfficeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param string|null $countryId
     * @param int $limit
     * @return JsonResponse
     */
    public function __invoke(int $limit = 10, string $countryId = null): JsonResponse
    {
        return $this->successResponse(
            Office::query()
                ->with([
                    'country',
                    'media'
                ])
                ->latest()
                ->where(function ($query) use ($countryId) {
                    $query->orWhere('country_id', 'ilike', '%' . $countryId . '%');
                })
                ->limit($limit)
                ->get()
        );
    }
}
