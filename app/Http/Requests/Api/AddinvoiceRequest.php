<?php

namespace App\Http\Requests\Api;

use App\Traits\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;

class AddinvoiceRequest extends FormRequest
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
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'zipCode' => 'nullable|string',
            'country' => 'nullable|string',
            'combineDate' => 'required|date|after_or_equal:today',
            'dueDate' => 'required|date|after_or_equal:combineDate',
            'isDiscount' => 'required|boolean',
            'discountCode' => $this->input('isDiscount') ? 'required|string' : '',
            'shippingCharges' => 'numeric|min:0',
            'isRecurring' => 'required|boolean',
            'recurringType' => $this->input('isRecurring') ? 'required|in:Monthly,Weekly,Daily,Hourly' : '',
            'isPartial' => 'required|boolean',
            'currentAmount' => $this->input('isPartial') ? 'required|numeric|min:0' : '',
            'isEmailed' => 'required|boolean',
            'notes' => 'nullable|string',
            'userId' => 'required|numeric',
            'brand' => 'required|numeric',
            'paymentLink' => 'nullable|string',
            'services' => 'required|array',
            'services.*.name' => 'required|string',
            'services.*.description' => 'nullable|string',
            'services.*.qty' => 'nullable|numeric|min:0',
            'services.*.price' => 'required|numeric|min:0',
        ];
    }
}
