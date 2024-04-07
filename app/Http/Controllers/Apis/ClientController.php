<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddclientRequest;
use App\Models\Apis\Client;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    public function addClient(AddclientRequest $request)
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
        $client->createdBy = $request->createdBy ?? 'User';
        $client->notes = $request->notes ?? 'NA';

        // Save the client to the database
        $addClient = $client->save();

        if ($addClient) {
            // Return a success response
            return response()->json([
                'status' => 201,
                'message' => 'Client added successfully'
            ], 201);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Something went wrong.'
            ], 404);
        }
    }
}
