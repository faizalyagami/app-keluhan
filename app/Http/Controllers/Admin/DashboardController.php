<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Keluhan;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\Masyarakat;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.admin.dashboard', [
            'keluhan' => Keluhan::count(),
            'proses' => Keluhan::where('status', 'proses')->count(),
            'selesai' => Keluhan::where('status', 'selesai')->count(),
            'mahasiswa' => Mahasiswa::count(),
        ]);
    }
}
