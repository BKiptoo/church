<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ContactController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param ContactRequest $request
     * @return JsonResponse
     */
    public function __invoke(ContactRequest $request): JsonResponse
    {
        return $this->successResponse(
            Contact::query()->create($request->validated()),
            Response::HTTP_CREATED
        );
    }
}
