<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DetailKelasController extends Controller
{
    public function index()
    {
        return view('detail-kelas');
    }

    public function tugas()
    {
        return view('detail-tugas');
    }
}
