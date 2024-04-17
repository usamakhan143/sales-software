<?php

namespace App\Http\Requests\Api;

use App\Traits\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;

class SendinvoiceRequest extends FormRequest
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
            'customEmail' => 'required|boolean',
            'email' =>  $this->input('customEmail') ? 'required|email|unique:clients,email' : 'nullable',
            'invoiceId' => 'required|numeric'
        ];
    }
}
