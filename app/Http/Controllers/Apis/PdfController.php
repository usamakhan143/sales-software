<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
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
        $data = [
            'title' => 'Welcome to raviyatechnical',
            'image' => asset('dummy.jpg'),
            'items' => [
                ['name' => 'Item 1', 'price' => 100],
                ['name' => 'Item 2', 'price' => 200],
                ['name' => 'Item 3', 'price' => 300],
            ],
        ];

        $pdf = PDF::loadView('pdf.invoice', ['data' => $data])->setPaper('A4', 'portrait')->setOption($pdfOptions);

        return $pdf->download('raviyatechnical.pdf');
    }
}
