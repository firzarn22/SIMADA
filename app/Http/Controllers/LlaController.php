<?php

namespace App\Http\Controllers;

use App\Models\Lla;

class LlaController extends Controller
{
    public function index()
    {
        // Ambil data dari database
        $data = Lla::all();
        return view('lla.index', compact('data'));
    }
}
