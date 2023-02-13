<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Contact;
use App\Models\Post;
use App\Models\Subscriber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param CommentRequest $request
     * @return JsonResponse
     */
    public function __invoke(CommentRequest $request): JsonResponse
    {
        return $this->successResponse(
            Contact::query()->create([
                'commentable_id'=> $request->post_id,
                'commentable_type'=> Post::class,
                'email'=> $request->email,
                'clientIP'=> $request->getClientIp(),
                'comment'=> $request->comment,
            ]),
            Response::HTTP_CREATED
        );
    }
}
