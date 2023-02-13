<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    public mixed $comment;
    public mixed $email;
    public mixed $post_id;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'post_id' => ['string', 'required', 'exists:posts,id'],
            'email' => ['string', 'required', 'email'],
            'comment' => ['string', 'required'],
        ];
    }
}
