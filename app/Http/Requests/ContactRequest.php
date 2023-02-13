<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'country_id' => ['string', 'required', 'exists:countries,id'],
            'firstName' => ['string', 'required', 'max:255'],
            'description' => ['string', 'required'],
            'subject' => ['string', 'required', 'max:255'],
            'lastName' => ['string', 'required', 'max:255'],
            'email' => ['string', 'email', 'required', 'max:255'],
            'phoneNumber' => ['numeric', 'required'],
        ];
    }
}
