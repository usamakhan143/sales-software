<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Models\Apis\Invoice;
use Illuminate\Http\Request;
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

        return $pdf->download($data->invoiceNumber . '.pdf');
    }
}
