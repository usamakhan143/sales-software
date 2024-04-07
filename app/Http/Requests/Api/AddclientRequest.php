<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ApiResponseTrait;

class AddclientRequest extends FormRequest
{
    use ApiResponseTrait;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'clientName' => 'required|string',
            'email' => 'required|email|unique:clients,email',
            'phone' => 'nullable|string',
            'password' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'zipCode' => 'nullable|string',
            'country' => 'nullable|string',
            'badge' => 'nullable|string',
            'status' => 'boolean',
            'createdBy' => 'required|numeric',
            'notes' => 'nullable|string',
        ];
    }
}
