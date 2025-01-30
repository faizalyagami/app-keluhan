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

        $keluhanQuery = Keluhan::with(['kategori']);

        if ($loggedPetugas->roles == 'petugas') {
            $keluhanQuery->whereHas('struktural', function ($query) use ($loggedPetugas) {
                if (in_array($loggedPetugas->nama_petugas, [
                    'Dr. Dewi Sartika, M.Si'
                ])) {
                    $query->where('nama_struktural', 'Dekan Fakultas');
                } elseif (in_array($loggedPetugas->nama_petugas, [
                    'Dr. Siti Qodariah, M.Psi.',
                    'Farida Coralia, S.Psi., M.Psi.',
                ])) {
                    $query->where('nama_struktural', 'Bidang Akademik S1');
                } elseif (in_array($loggedPetugas->nama_petugas, [
                    'Dr. Eneng Nurlaili Wangi, M.Psi.',
                    'Dr. Endah Nawangsih, Dra., M.Psi.',
                ])) {
                    $query->where('nama_struktural', 'Bidang Akademik Profesi');
                } elseif (in_array($loggedPetugas->nama_petugas, [
                    'Ali Mubarak, S.Psi., M.Psi.',
                    'Nida Hamidah, S.Psi'
                ])) {
                    $query->whereIn('nama_struktural', ['Bidang Akademik S1', 'Bidang Akademik Profesi']);
                } elseif (in_array($loggedPetugas->nama_petugas, [
                    'Dr. Lilim Halimah, BHSc., MHSPY.',
                    'Nurmariam'
                ])) {
                    $query->where('nama_struktural', 'Bidang Administrasi Umum dan Keuangan');
                } elseif (in_array($loggedPetugas->nama_petugas, [
                    'Suhana, S.Psi., M.Psi.',
                    'Undang Kamaludin'
                ])) {
                    $query->where('nama_struktural', 'Bidang Kemahasiswaan');
                } elseif (in_array($loggedPetugas->nama_petugas, [
                    'Rizka Hadian Permana, S.Psi., M.Psi.'
                ])) {
                    $query->where('nama_struktural', 'Laboratorium Psikologi');
                }
            });
        }

        $keluhanCount = (clone $keluhanQuery)->count();
        $prosesCount = (clone $keluhanQuery)->where('status', 'proses')->count();
        $selesaiCount = (clone $keluhanQuery)->where('status', 'selesai')->count();
        $mahasiswaCount = Mahasiswa::count();

        return view('pages.admin.dashboard', [
            'keluhan' => $keluhanCount,
            'proses' => $prosesCount,
            'selesai' => $selesaiCount,
            'mahasiswa' => $mahasiswaCount,
        ]);
    }

    /**
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
     */
}
