<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PDFController extends Controller
{
    public function generatePDF($id)
    {
        $selectedModul = DB::table('guru')
            ->join('modul', 'modul.guru_id', '=', 'guru.id')
            ->where('modul.id', $id)
            ->get();


        //instantiate Dompdf
        $dompdf = new Dompdf();

        //Load HTML Content from a View
        $dompdf->setBasePath(public_path());
        $html = view('pages.detailmateri', compact('selectedModul'))->render();
        $dompdf->loadHtml($html);

        //Set paper size and rendering options
        $dompdf->setPaper('A4', 'potrait');

        //Render the HTML as PDF
        $dompdf->render();

        //Output the generated PDF to the Browser
        $dompdf->stream('document.pdf');
    }
}
