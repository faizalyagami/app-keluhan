<?php

namespace App\Http\Controllers\Admin;

use App\Models\Keluhan;
use App\Models\Mahasiswa;
use App\Models\Pengaduan;
use App\Models\Masyarakat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $loggedPetugas = Auth::guard('admin')->user();

        $keluhanCount = Keluhan::when(
            $loggedPetugas->roles == 'petugas',
            function ($query) use ($loggedPetugas) {
                $query->where('id_struktural', $loggedPetugas->id_struktural);
            }
        )->count();

        $prosesCount = Keluhan::when(
            $loggedPetugas->roles == 'petugas',
            function ($query) use ($loggedPetugas) {
                $query->where('id_struktural', $loggedPetugas->id_struktural);
            }
        )->where('status', 'proses')->count();

        $selesaiCount = Keluhan::when(
            $loggedPetugas->roles == 'petugas',
            function ($query) use ($loggedPetugas) {
                $query->where('id_struktural', $loggedPetugas->id_struktural);
            }
        )->where('status', 'selesai')->count();

        $mahasiswaCount = Mahasiswa::count();

        return view('pages.admin.dashboard', [
            'keluhan' => $keluhanCount,
            'proses' => $prosesCount,
            'selesai' => $selesaiCount,
            'mahasiswa' => $mahasiswaCount,
        ]);
    }
}
