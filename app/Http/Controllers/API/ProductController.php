<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
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
            Product::query()
                ->with([
                    'country',
                    'media',
                    'comments',
                    'category',
                    'subCategory'
                ])
                ->latest()
                ->orWhereIn('country_id', [$countryId])
                ->limit($limit)
                ->get()
        );
    }
}
