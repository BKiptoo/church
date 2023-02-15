<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Team;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TeamController extends Controller
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
            Team::query()
                ->with([
                    'country',
                    'media'
                ])
                ->latest()
                ->orWhereIn('country_id', [$countryId])
                ->limit($limit)
                ->get()
        );
    }
}
