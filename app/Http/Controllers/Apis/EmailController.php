<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SendinvoiceRequest;
use App\Mail\SendInvoiceEmail;
use App\Models\Apis\Invoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Swift_TransportException;

class EmailController extends Controller
{
    public function sendInvoiceToCustomer(SendinvoiceRequest $request)
    {
        $getInvoice = Invoice::where('id', $request->invoiceId)->first();
        $getInvoicePdfId = $getInvoice->getPdfInvoice->id ?? null;
        $email = ($request->email !== null && $request->customEmail !== false) ? $request->email : $getInvoice->clientDetails->email;
        if ($getInvoicePdfId != null) {
            if (app()->isLocal()) {
                $pdfPath = public_path($getInvoice->getPdfInvoice->file_url);
            } else {
                $pdfPath = storage_path($getInvoice->getPdfInvoice->file_url);
            }

            // Parse the date using Carbon
            $invoiceDate = Carbon::parse($getInvoice->combineDate);

            // Format the date
            $formattedDate = $invoiceDate->format('F d, Y');

            $subject = 'Invoice #' . $getInvoice->invoiceNumber . ' - ' . $formattedDate;

            $data = [
                'data' => $getInvoice,
                'pdf' => $pdfPath,
                'subject' => $subject
            ];
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Email Not send No Invoice PDF found.',
                'recipent' => $email
            ], 404);
        }

        // Try sending an email and handle exceptions
        try {
            Mail::to($email)->send(new SendInvoiceEmail($data));
        } catch (Swift_TransportException $e) {
            return response()->json([
                'status' => 404,
                'message' => 'Email sending is disabled because the mailer is not configured to use SMTP.',
                'link' => 'No Invoice PDF Found'
            ], 404);
        }
        return [
            'status' => 200,
            'message' => 'Email sent with attachement successfully.',
            'recipent' => $email
        ];
    }
}
