<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'invoiceNumber' => $this->invoiceNumber,
            'combineDate' => $this->combineDate,
            'day' => $this->day,
            'month' => $this->month,
            'year' => $this->year,
            'dueDate' => $this->dueDate,
            'isDiscount' => $this->isDiscount,
            'discount_id' => $this->discount_id,
            'shippingCharges' => $this->shippingCharges,
            'isRecurring' => $this->isRecurring,
            'recurringType' => $this->recurringType,
            'subTotal' => $this->subTotal,
            'currentAmount' => $this->currentAmount,
            'totalAmount' => $this->totalAmount,
            'totalAmountDue' => $this->totalAmountDue,
            'isEmailed' => $this->isEmailed,
            'notes' => $this->notes,
            'payLink' => $this->payLink,
            'paymentStatus' => $this->paymentStatus,
            'userId' => $this->userId,
            'client' => new ClientResource($this->clientDetails),
            'offerservices' => $this->offerServices,
            'brand' => new AddbrandResource($this->brand),
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}
