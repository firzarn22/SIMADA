<?php

namespace App\Http\Controllers;

use App\Models\Statistic; // <-- WAJIB: panggil model Statistic

class DashboardController extends Controller
{
    public function index()
    {
       $stats = \App\Models\Statistic::all();

        return view('dashboard', compact('stats'));
    }
}
