<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Career;
use Illuminate\Http\JsonResponse;

class CareerController extends Controller
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
            Career::query()
                ->with([
                    'country'
                ])
                ->latest()
                ->whereDate('deadLine', '>=', today())
                ->where(function ($query) use ($countryId) {
                    $query->orWhere('country_id', 'ilike', '%' . $countryId . '%');
                })
                ->limit($limit)
                ->get()
        );
    }
}
