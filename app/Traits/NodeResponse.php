<?php


namespace App\Traits;


use App\Http\Resources\API;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

trait NodeResponse
{
    /**
     * success response
     * @param $data
     * @param int|null $code
     * @return JsonResponse
     */
    public function successResponse($data, int|null $code = null): JsonResponse
    {
        $code ??= Response::HTTP_OK;

        if (method_exists((object)$data, 'links')) {
            return API::collection($data)
                ->additional([
                    'headers' => request()->header(),
                    'success' => true
                ])
                ->response()
                ->setStatusCode($code);
        }

        if ($data instanceof Collection) {
            return API::collection($data)
                ->additional([
                    'headers' => request()->header(),
                    'success' => true
                ])
                ->response()
                ->setStatusCode($code);
        }

        // proceed
        return (new API($data))
            ->additional([
                'headers' => request()->header(),
                'success' => true
            ])
            ->response()
            ->setStatusCode($code);
    }

    /**
     * error response
     * @param $message
     * @param $code
     * @return JsonResponse
     */
    public function errorResponse($message, $code): JsonResponse
    {
        return (new API([
            array(
                'key' => 'Message',
                'errors' => array($message)
            )
        ]))->additional([
            'headers' => request()->header(),
            'success' => false,
        ])->response()->setStatusCode($code);
    }

    /**
     * system error responses
     * @param $data
     * @param int|null $code
     * @return JsonResponse
     */
    public function showErrors($data, int|null $code = null): JsonResponse
    {
        $code ??= Response::HTTP_UNPROCESSABLE_ENTITY;

        return (new API($data))
            ->additional([
                'headers' => request()->header(),
                'success' => false
            ])->response()->setStatusCode($code);
    }
}
