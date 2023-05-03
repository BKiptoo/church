<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->successResponse(
            SubCategory::query()->with([
                'category.media',
                'posts.media',
                'products.media',
            ])->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param SubCategory $subCategory
     * @return JsonResponse
     */
    public function show(SubCategory $subCategory): JsonResponse
    {
        return $this->successResponse(
            $subCategory->load(
                'category.media',
                'posts.media',
                'products.media',
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param SubCategory $subCategory
     * @return Response
     */
    public function update(Request $request, SubCategory $subCategory)
    {
        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param SubCategory $subCategory
     * @return Response
     */
    public function destroy(SubCategory $subCategory)
    {
        abort(403);
    }
}
