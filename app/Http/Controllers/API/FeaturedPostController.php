<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\JsonResponse;

class FeaturedPostController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param int $limit
     * @param string|null $countryId
     * @return JsonResponse
     */
    public function __invoke(int $limit = 3, string $countryId = null): JsonResponse
    {
        return $this->successResponse(
            Post::query()
                ->with([
                    'country',
                    'media',
                    'user.media',
                    'comments',
                    'category',
                    'subCategory'
                ])
                ->where('isFeatured', true)
                ->inRandomOrder()
                ->where(function ($query) use ($countryId) {
                    $query->orWhere('country_id', 'ilike', '%' . $countryId . '%');
                })
                ->limit($limit)
                ->get()
        );
    }
}
