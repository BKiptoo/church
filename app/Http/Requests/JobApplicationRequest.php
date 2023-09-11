<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobApplicationRequest extends FormRequest
{
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
            'career_id' => ['uuid', 'required', 'exists:careers,id'],
            'linkedInUrl' => ['string', 'url', 'nullable'],
            'email' => ['string', 'email', 'required'],
            'firstName' => ['string', 'required'],
            'lastName' => ['string', 'required'],
            'coverLetter' => ['string', 'required'],
            'phoneNumber' => ['numeric', 'required'],
//            'cv' => ['file', 'max:10192', 'required'] // 10MB Max
            'cv' => ['string', 'required', 'url']
        ];
    }
}
