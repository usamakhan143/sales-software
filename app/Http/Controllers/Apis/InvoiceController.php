<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddinvoiceRequest;
use App\Models\Apis\Client;
use App\Models\Apis\Invoice;
use App\Models\Apis\Offerservice;
use Illuminate\Support\Facades\Hash;

class InvoiceController extends Controller
{
    public function createInvoice(AddinvoiceRequest $request)
    {
        // Create a new instance of the Client model
        $client = new Client();

        // Assign values from the request to the client object
        $client->name = $request->clientName;
        $client->email = $request->email;
        $client->phone = $request->phone ?? 'NA';
        $client->password = Hash::make($request->password) ?? 'NA';
        $client->address = $request->address ?? 'NA';
        $client->city = $request->city ?? 'NA';
        $client->state = $request->state ?? 'NA';
        $client->zipCode = $request->zipCode ?? 'NA';
        $client->country = $request->country ?? 'NA';
        $client->badge = $request->badge ?? 'NA';
        $client->status = $request->status ?? 1;
        $client->notes = $request->notes ?? 'NA';
        $client->createdBy = $request->userId ?? 0;
        // Save the client to the database
        $addClient = $client->save();

        if ($addClient) {

            // Create a new invoice instance
            $invoice = new Invoice();

            // Assign the invoice data
            $invoice->invoiceNumber = $this->generateSequentialInvoiceNumber(); // Generate Sequential $InvoiceNumber
            $invoice->combineDate = $request->combineDate; // Assuming combine date is used for combine date
            $invoice->day = date('d', strtotime($request->combineDate)); // Extract day from combine date
            $invoice->month = date('m', strtotime($request->combineDate)); // Extract month from combine date
            $invoice->year = date('Y', strtotime($request->combineDate)); // Extract year from combine date
            $invoice->dueDate = $request->dueDate; // Assuming due date is available
            $invoice->notes = $request->notes; // Assuming notes is available
            $invoice->userId = $request->userId; // Assuming userId is available
            $invoice->client_id = $client->id; // Assuming clientId is available
            $invoice->brand_id = $request->brand; // Assuming brandId is available
            $invoice->status = true; // Assuming status is available and set to true

            // Set optional fields if provided
            $invoice->isDiscount = $request->input('isDiscount') ?? false;
            $invoice->discount_id = 0;
            $invoice->shippingCharges = $request->input('shippingCharges') ?? 0;
            $invoice->isRecurring = $request->input('isRecurring') ?? false;
            $invoice->recurringType = $request->input('recurringType') ?? 'NA';
            if ($request->input('isEmailed') === true) {
                $invoice->paymentStatus = 'Sent';
            } else {
                $invoice->paymentStatus = 'Draft';
            }

            $invoice->isEmailed = $request->input('isEmailed');
            $invoice->payLink = $request->input('paymentLink') ?? 'NA';


            // Calculate the total price of all services
            $totalPrice = collect($request->services)->sum(function ($service) {
                return $service['price'] * $service['qty'];
            });
            // Calculate Total Amount
            $totalAmount = $totalPrice + $request->input('shippingCharges');
            // Calculate Due Amount
            if ($request->currentAmount != null) {
                if ($request->currentAmount <= $totalPrice) {
                    $dueAmount = $totalAmount - $request->currentAmount;
                } else {
                    $dueAmount = $totalAmount - $request->currentAmount;
                    Client::find($client->id)->delete();
                    return response()->json([
                        'status' => 404,
                        'dueAmount' => $dueAmount,
                        'message' => "Due amount should not be less than 0."
                    ], 404);
                }
            } else {
                Client::find($client->id)->delete();
                return response()->json([
                    'status' => 404,
                    'totalAmount' => $totalPrice,
                    'message' => "Current amount should be less than total amount."
                ], 404);
            }
            $invoice->subTotal = $totalPrice; // Assuming subTotal is available
            $invoice->currentAmount = $request->currentAmount ?? 0; // Assuming currentAmount is available
            $invoice->totalAmount = $totalAmount; // totalAmount is calculated
            $invoice->totalAmountDue = $dueAmount;
            // Save the invoice
            $saveInvoice = $invoice->save();

            // Check if the invoice is saved successfully
            if ($saveInvoice) {

                foreach ($request->services as $serviceData) {
                    $service = new Offerservice($serviceData);
                    $invoice->offerServices()->save($service);
                }
                // Optionally, return a success response
                return response()->json([
                    'status' => 201,
                    'message' => 'Invoice added successfully',
                    'invoice' => $invoice
                ], 201);
            } else {
                // Optionally, return an error response if the invoice failed to save
                return response()->json([
                    'status' => 500,
                    'message' => 'Failed to create invoice'
                ], 500);
            }

            // Return a success response
            // return response()->json([
            //     'status' => 201,
            //     'message' => 'Client added successfully'
            // ], 201);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'There is something went wrong during client registeration.'
            ], 404);
        }
    }


    // Function to generate the next sequential invoice number
    private function generateSequentialInvoiceNumber()
    {
        // Get the last invoice from the database
        $lastInvoice = Invoice::latest()->first();

        // Check if there are any invoices in the database
        if ($lastInvoice) {
            // Extract the invoice number and increment it
            $lastInvoiceNumber = $lastInvoice->invoiceNumber;
            $nextInvoiceNumber = str_pad((intval($lastInvoiceNumber) + 1), 4, '0', STR_PAD_LEFT); // Pad with leading zeros
        } else {
            // If no invoices exist, start with "0001"
            $nextInvoiceNumber = '0001';
        }

        return $nextInvoiceNumber;
    }
}
