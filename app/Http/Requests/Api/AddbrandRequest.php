<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

use App\Traits\ApiResponseTrait;

class AddbrandRequest extends FormRequest
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
            'name' => 'required|string',
            'fullName' => 'required|string',
            'tagLine' => 'required|string',
            'logo' => 'required|file|mimes:jpg,png,jpeg',
            'smallLogo' => 'required|file|mimes:jpg,png,jpeg',
            'phone' => 'required|string',
            'email' => 'required|email',
        ];
    }
}