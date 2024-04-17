<?php

namespace App\Http\Controllers\Apis;

use App\Helpers\Fileupload;
use App\Http\Controllers\Controller;
use App\Models\Apis\Invoice;
use PDF;

class PdfController extends Controller
{
    public function generatePDF($id)
    {
        $pdfOptions = [
            'dpi' => 100,
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true
        ];
        $data = Invoice::find($id);

        $pdf = PDF::loadView('pdf.invoice', ['data' => $data])->setPaper('A4', 'portrait')->setOption($pdfOptions);

        // Saving PDF to the directory.
        $pdfData = [
            'folder_name' => 'invoices',
            'file_name' => $data->invoiceNumber,
            'file_type' => 'invoice-pdf',
            'file_ext' => 'pdf',
            'invoice_id' => $data->id
        ];

        $pdfPath = Fileupload::pdfUpload($pdf, $pdfData['folder_name'], $pdfData['file_name']);

        // Storing the PDF path inside the db.
        $saveInDb = Fileupload::addFile($pdfPath, $pdfData['file_type'], $pdfData['file_ext'], 0, $data->brand_id, $pdfData['invoice_id']);

        // Setup the PDF path based on the enviroment.
        if (app()->isLocal()) {
            $getFullPath = $saveInDb['data']->base_url . $saveInDb['data']->file_url;
        } else {
            $getFullPath = $saveInDb['data']->base_url . 'storage/' . $saveInDb['data']->file_url;
        }

        return response()->json([
            "status" => 201,
            "message" => "Invoice PDF generated and saved successfully.",
            "pdf" => $getFullPath,
            "id" => $saveInDb['data']->id
        ], 201);
    }
}
