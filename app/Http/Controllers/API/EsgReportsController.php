<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Esg;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EsgReportsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        return $this->successResponse(
            Esg::query()
                ->with([
                    'media'
                ])
                ->latest()
                ->get()
        );
    }
}
