<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SendinvoiceRequest;
use App\Models\Apis\Invoice;

class EmailController extends Controller
{
    public function sendInvoiceToCustomer(SendinvoiceRequest $request)
    {
        $getInvoice = Invoice::where('id', $request->invoiceId)->first();

        if (app()->isLocal()) {
            $pdfPath = public_path($getInvoice->getPdfInvoice->file_url);
        } else {
            $pdfPath = storage_path($getInvoice->getPdfInvoice->file_url);
        }


        return response()->json([$request->all()]);
    }
}
