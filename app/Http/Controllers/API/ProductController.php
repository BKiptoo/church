<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param string|null $countryId
     * @param int $limit
     * @return JsonResponse
     */
    public function index(int $limit = 100, string $countryId = null): JsonResponse
    {
        return $this->successResponse(
            Product::query()
                ->with([
                    'country',
                    'media',
                    'category',
                    'subCategory'
                ])
                ->latest()
                ->where(function ($query) use ($countryId) {
                    $query->orWhere('country_id', 'ilike', '%' . $countryId . '%');
                })
                ->limit($limit)
                ->get()
        );
    }

    /**
     * fetch specific product
     * @param string $slug
     * @return JsonResponse
     */
    public function show(string $slug): JsonResponse
    {
        $product = Product::query()
            ->with([
                'country',
                'media',
                'category',
                'subCategory'
            ])
            ->firstWhere('slug', $slug);

        return $this->successResponse($product);
    }
}
