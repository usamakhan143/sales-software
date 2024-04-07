<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddbrandRequest;
use App\Models\Apis\Brand;

class BrandController extends Controller
{
    public function createBrand(AddbrandRequest $request)
    {
        $brand = new Brand();

        // Assign values from the request to the brand object
        $brand->name = $request->name;
        $brand->fullName = $request->fullName;
        $brand->tagLine = $request->tagLine;
        $brand->logo = $request->logo;
        $brand->smallLogo = $request->smallLogo;
        $brand->phone = $request->phone;
        $brand->email = $request->email;

        // Save the brand to the database
        $saveBrand = $brand->save();

        if ($saveBrand) {
            // Return a success response
            return response()->json([
                'status' => 201,
                'message' => 'Brand added successfully',
                'data' => $brand
            ], 201);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Something went wrong.'
            ], 404);
        }
    }
}
