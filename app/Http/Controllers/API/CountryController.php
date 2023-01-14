<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Traits\NodeResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CountryController extends Controller
{
    use NodeResponse;

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->successResponse(
            Country::query()
                ->with([
                    'coverages.mediaable',
                    'ads.mediaable',
                    'careers',
                    'contacts',
                    'faqs',
                    'offices.mediaable',
                    'partners.mediaable',
                    'posts.mediaable',
                    'posts.user',
                    'posts.category.subCategory',
                    'products.mediaable',
                    'products.category.subCategory',
                    'slides.mediaable',
                    'subScribers',
                    'tenders.mediaable',
                    'teams.mediaable'
                ])
                ->orderBy('name')
                ->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param Country $country
     * @return JsonResponse
     */
    public function show(Country $country): JsonResponse
    {
        return $this->successResponse(
            $country->load(
                'coverages.mediaable',
                'ads.mediaable',
                'careers',
                'contacts',
                'faqs',
                'offices.mediaable',
                'partners.mediaable',
                'posts.mediaable',
                'posts.user',
                'posts.category.subCategory',
                'products.mediaable',
                'products.category.subCategory',
                'slides.mediaable',
                'subScribers',
                'tenders.mediaable',
                'teams.mediaable'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Country $country
     * @return Response
     */
    public function update(Request $request, Country $country): Response
    {
        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Country $country
     * @return Response
     */
    public function destroy(Country $country): Response
    {
        abort(403);
    }
}
