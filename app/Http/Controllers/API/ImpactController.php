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
    public function index(int $limit = 500, string $impactTypeSlug = null): JsonResponse
    {
        return $this->successResponse(
            Impact::query()
                ->with([
                    'impactType',
                    'media'
                ])
                ->inRandomOrder()
                ->where(function ($query) use ($impactTypeSlug) {
                    $query->orWhereRelation('impactType', 'slug', 'ilike', '%' . $impactTypeSlug . '%');
                })
                ->limit($limit)
                ->get()
        );
    }

    /**
     * fetch specific impact
     * @param string $slug
     * @return JsonResponse
     */
    public function show(string $slug): JsonResponse
    {
        return $this->successResponse(
            Impact::query()
                ->with([
                    'impactType',
                    'media'
                ])
                ->firstWhere('slug', $slug)
        );
    }
}
