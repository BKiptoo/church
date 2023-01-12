<?php

namespace App\Http\Controllers;

use App\Traits\NodeResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, NodeResponse;

    /**
     * Add this method to the Controller class
     * @param $token
     * @return JsonResponse
     */
    protected function respondWithToken($token): JsonResponse
    {
        return $this->successResponse(
            [
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => (auth('api')->factory()->getTTL()) // expires in 24hr
            ]
        );
    }
}
