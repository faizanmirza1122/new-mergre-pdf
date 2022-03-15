<?php

namespace App\Http\Controllers;

use App\Models\pdf as File;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PDFController extends Controller
{
 
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $files = File::get();
        return view('pdf.create', ['files' => $files]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'file' => ['required', 'mimes:pdf,xlx,csv', 'max:2048'],
            'file_path' => ['nullable'],
            
        ]);


        if ($request->file('file')) {
            $file = $request->file('file');
            $fileName = Str::random(8) . '.' . $request->file->extension();
            $path = Storage::putFileAs('public/files', $file, $fileName);
            $data['file_path'] = $path;
            $data['file'] = $fileName;
        }
        // dd($path);

        // dd($data);
        File::create($data);
   
        return redirect()->route('file.index')->with('success', 'PDF File successfully saved');
   
    }
    
}
