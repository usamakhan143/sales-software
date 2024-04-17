<?php

namespace App\Http\Controllers\Apis;

use App\Helpers\Fileupload;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddbrandRequest;
use App\Http\Resources\AddbrandResource;
use App\Models\Apis\Brand;

class BrandController extends Controller
{
    public function createBrand(AddbrandRequest $request)
    {
        $brand = new Brand();
        $originalLogoRequest = $request->file('logo');
        $smallLogoRequest = $request->file('smallLogo');

        // Assign values from the request to the brand object
        $brand->name = $request->name;
        $brand->fullName = $request->fullName;
        $brand->tagLine = $request->tagLine;
        $brand->logo = 'Logo';
        $brand->smallLogo = 'small Logo';
        $brand->phone = $request->phone;
        $brand->email = $request->email;

        // Save the brand to the database
        $saveBrand = $brand->save();

        if ($saveBrand) {

            $originalLogoImage_data = [
                'folderName' => 'brand-logos',
                'imageName' => 'brand-logo',
                'file_type' => 'original-logo',
                'file_ext_type' => 'image',
                'brandId' => $brand->id,
                'userId' => 0,
            ];

            $smallLogoImage_data = [
                'folderName' => 'brand-logos',
                'imageName' => 'brand-small-logo',
                'file_type' => 'small-logo',
                'file_ext_type' => 'image',
                'brandId' => $brand->id,
                'userId' => 0,
            ];
            // Save logos to folder.
            $originalLogo = Fileupload::singleUploadFile($originalLogoRequest, $originalLogoImage_data['brandId'], $originalLogoImage_data['folderName'], $originalLogoImage_data['imageName']);
            $smallLogo = Fileupload::singleUploadFile($smallLogoRequest, $smallLogoImage_data['brandId'], $smallLogoImage_data['folderName'], $smallLogoImage_data['imageName']);
            // Save logos to db.
            $save_logo = Fileupload::addFile($originalLogo, $originalLogoImage_data['file_type'], $originalLogoImage_data['file_ext_type'], $originalLogoImage_data['userId'], $originalLogoImage_data['brandId'], 0);
            $save_small_logo = Fileupload::addFile($smallLogo, $smallLogoImage_data['file_type'], $smallLogoImage_data['file_ext_type'], $smallLogoImage_data['userId'], $smallLogoImage_data['brandId'], 0);
            if ($save_logo['isSave'] && $save_small_logo['isSave']) {
                // Return a success response
                return response()->json([
                    'status' => 201,
                    'message' => 'Brand added successfully',
                    'data' => new AddbrandResource($brand)
                ], 201);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Something went wrong.'
            ], 404);
        }
    }
}
