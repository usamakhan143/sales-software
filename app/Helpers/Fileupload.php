<?php

namespace App\Helpers;

use App\Models\Apis\File;

class Fileupload
{

    static function singleUploadFile($uploadedFile, $entityid, $folderName, $name)
    {

        // $file_size = $uploadedFile->getSize();
        // dd($uploadedFile->getRealPath());
        $file_ext = $uploadedFile->getClientOriginalExtension();

        $file_name = $name . "_" . $entityid . "." . $file_ext;

        if (request()->getHttpHost() == '127.0.0.1:8000') {
            $path = public_path($folderName); // '/profile_images/'
        } else {
            $path = storage_path($folderName); // '/profile_images/'
        }

        $uploadedFile->move($path, $file_name);

        // $img->move($path, $file_name);

        $fullpath = $folderName . '/' . $file_name;

        return $fullpath;
    }

    static function multiUploadFile($photo_array, $countPhoto, $folderName, $name)
    {

        for ($i = 0; $i < $countPhoto; $i++) {
            // $photo_size = $photo_array[$i]->getSize();
            $photo_ext = $photo_array[$i]->getClientOriginalExtension();

            $image_name = $name . rand(123456, 999999) . "." . $photo_ext;

            if (request()->getHttpHost() == '127.0.0.1:8000') {
                $path = public_path($folderName);
            } else {
                $path = storage_path($folderName);
            }

            $photo_array[$i]->move($path, $image_name);

            $fullpath[$i] = $folderName . '/' . $image_name;
        }

        $fullpath_array = $fullpath;
        return $fullpath_array;
    }


    public static function addFile($imageFile, $file_type, $file_ext_type, $userId, $brandId, $invoiceId)
    {
        $add_file = new File();
        $add_file->file_url = $imageFile;
        $add_file->base_url = url('') . '/';
        $add_file->file_type = $file_type;
        $add_file->file_ext_type = $file_ext_type;
        $add_file->brand_id = $brandId ?? 0;
        $add_file->user_id = $userId;
        $add_file->invoice_id = $invoiceId;

        $Save = $add_file->save();
        return [
            'isSave' => $Save,
            'data' => $add_file
        ];
    }

    static function pdfUpload($pdf, $folderName, $name)
    {
        if (request()->getHttpHost() == '127.0.0.1:8000') {
            $path = public_path('pdf/' . $folderName) . '/' . $name . '.pdf';
        } else {
            $path = storage_path('pdf/' . $folderName) . '/' . $name . '.pdf';
        }

        $pdf->save($path);
        $fullpath = 'pdf/' . $folderName . '/' . $name . '.pdf';

        return $fullpath;
    }
}
