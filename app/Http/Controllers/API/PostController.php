<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param string|null $countryId
     * @param int $limit
     * @return JsonResponse
     */
    public function index(int $limit = 10, string $countryId = null): JsonResponse
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
                ->latest()
                ->where(function ($query) use ($countryId) {
                    $query->orWhere('country_id', 'ilike', '%' . $countryId . '%');
                })
                ->limit($limit)
                ->get()
        );
    }

    /**
     * fetch specific posts
     * @param string $slug
     * @return JsonResponse
     */
    public function show(string $slug): JsonResponse
    {
        $post = Post::query()
            ->with([
                'country',
                'media',
                'user.media',
                'comments',
                'category',
                'subCategory'
            ])
            ->firstWhere('slug', $slug);

        // increment views
        $post->update([
            'views' => $post->views + 1
        ]);

        return $this->successResponse($post);
    }
}
