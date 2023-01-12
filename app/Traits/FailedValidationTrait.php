<?php


namespace App\Traits;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait FailedValidationTrait
{
    use NodeResponse;

    /**
     * Customize the errors to be more
     * readable
     * @param Validator $validator
     */
    public function failedValidation(Validator $validator)
    {
        $errorResults = [];
        $errors = $validator->errors()->toArray();

        foreach ($errors as $key => $error) {
            $errorResults[] = [
                'key' => $key,
                'errors' => [...$error]
            ];
        }

        // initiate an error trigger
        throw new HttpResponseException($this->showErrors($errorResults));
    }
}
