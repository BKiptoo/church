<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SystemController;
use App\Http\Requests\JobApplicationRequest;
use App\Models\JobApplication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class JobApplicationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param JobApplicationRequest $request
     * @return JsonResponse
     */
    public function __invoke(JobApplicationRequest $request): JsonResponse
    {
        // create the application here
        $model = JobApplication::query()->create($request->validated());

        // upload cv here
        SystemController::singleMediaUploadsJob(
            $model->id,
            JobApplication::class,
            $request->file('cv')
        );

        return $this->successResponse(
            $model,
            Response::HTTP_CREATED
        );
    }
}
