<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;
use App\Models\Pdf;

class PdfMergeController extends Controller
{
    public function index() {
 
        // $d = Pdf::get()->pluck('file_path')->toArray();
        // dd($d);
        // $files = $d;
        $files = ['/public/files/KhAQ3kZp.pdf'];
        $pdf = new Fpdi();
 
        foreach ($files as $file) {
            // set the source file and get the number of pages in the document
            $pageCount =  $pdf->setSourceFile($file);
 
            for ($i=0; $i < $pageCount; $i++) { 
                //create a page
                $pdf->AddPage();
                //import a page then get the id and will be used in the template
                $tplId = $pdf->importPage($i+1);
                //use the template of the imporated page
                $pdf->useTemplate($tplId);
            }
        }
 
        //return the generated PDF
        return $pdf->Output();      
    }   
}
