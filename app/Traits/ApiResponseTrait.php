<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait ApiResponseTrait
{
    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'status' => 422,
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422);

        throw new HttpResponseException($response);
    }
}
