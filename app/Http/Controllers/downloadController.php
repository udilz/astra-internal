<?php

namespace App\Http\Controllers;



class downloadController extends Controller
{
    public function download($filename)
    {
        return response()->download(public_path('dokumens/' . $filename));
    }
}
