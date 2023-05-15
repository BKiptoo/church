<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $country_id
 * @property mixed $product_id
 * @property mixed $email
 */
class OrderRequest extends FormRequest
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
            'product_id' => ['string', 'required', 'exists:products,id'],
            'email' => ['string', 'required'],
        ];
    }
}
