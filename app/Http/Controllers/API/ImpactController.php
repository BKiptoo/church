<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Impact;
use Illuminate\Http\JsonResponse;

class ImpactController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param int $limit
     * @param string|null $impactTypeSlug
     * @return JsonResponse
     */
    public function __invoke(int $limit = 10, string $impactTypeSlug = null): JsonResponse
    {
        return $this->successResponse(
            Impact::query()
                ->with([
                    'impactType',
                    'media'
                ])
                ->latest()
                ->where(function ($query) use ($impactTypeSlug) {
                    $query->whereRelation('impactType', 'slug', 'ilike', '%' . $impactTypeSlug . '%');
                })
                ->limit($limit)
                ->get()
        );
    }
}
