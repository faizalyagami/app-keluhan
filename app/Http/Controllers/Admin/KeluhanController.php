<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Disposisi;
use Illuminate\Http\Request;
use App\Models\Keluhan;
use App\Models\Struktural;
use App\Models\Tanggapan;
use Illuminate\Support\Facades\Auth;
use App\Helpers\StrukturalHelper;
use App\Models\Evaluasi;

class KeluhanController extends Controller
{

    public function index($status)
    {

        $loggedPetugas = Auth::guard('admin')->user();
        // dd($loggedPetugas);

        $keluhan = Keluhan::with(['kategori', 'evaluasi'])
            ->where('status', $status)
            // ->when($loggedPetugas->roles == 'petugas', function ($q) use ($loggedPetugas) {
            //     if (in_array($loggedPetugas->nama_petugas, [
            //         'Dr. Dewi Sartika, M.Si'
            //     ])) {
            //         $q->wherehas('struktural', function ($query) {
            //             $query->where('nama_struktural', 'Dekan Fakultas');
            //         });
            //     } elseif (in_array($loggedPetugas->nama_petugas, [
            //         'Dr. Siti Qodariah, M.Psi.',
            //         'Farida Coralia, S.Psi., M.Psi.',
            //     ])) {
            //         $q->wherehas('struktural', function ($query) {
            //             $query->where('nama_struktural', 'Bidang Akademik S1');
            //         });
            //     } elseif (in_array($loggedPetugas->nama_petugas, [
            //         'Dr. Eneng Nurlaili Wangi, M.Psi.',
            //         'Dr. Endah Nawangsih, Dra., M.Psi.',
            //     ])) {
            //         $q->wherehas('struktural', function ($query) {
            //             $query->where('nama_struktural', 'Bidang Akademik Profesi');
            //         });
            //     } elseif (in_array($loggedPetugas->nama_petugas, [
            //         'Dr. Lilim Halimah, BHSc., MHSPY.',
            //         'Nurmariam'
            //     ])) {
            //         $q->wherehas('struktural', function ($query) {
            //             $query->where('nama_struktural', 'Bidang Administrasi Umum dan Keuangan');
            //         });
            //     } elseif (in_array($loggedPetugas->nama_petugas, [
            //         'Suhana, S.Psi., M.Psi.',
            //         'Undang Kamaludin'
            //     ])) {
            //         $q->wherehas('struktural', function ($query) {
            //             $query->where('nama_struktural', 'Bidang Kemahasiswaan');
            //         });
            //     } elseif (in_array($loggedPetugas->nama_petugas, [
            //         'Rizka Hadian Permana, S.Psi., M.Psi.'
            //     ])) {
            //         $q->whereHas('struktural', function ($query) {
            //             $query->where('nama_struktural', 'Laboratorium Psikologi');
            //         });
            //     } elseif (in_array($loggedPetugas->nama_petugas, [
            //         'Ali Mubarak, S.Psi., M.Psi.',
            //         'Nida Hamidah, S.Psi'
            //     ])) {
            //         $q->whereHas('struktural', function ($query) {
            //             $query->whereIn('nama_struktural', ['Bidang Akademik S1', 'Bidang Akademik Profesi']);
            //         });
            //     }
            // })
            ->orderBy('tgl_keluhan', 'desc')
            ->get();

        foreach ($keluhan as $k) {
            $k->first_evaluasi = $k->evaluasi->isEmpty() ? null : $k->evaluasi->first();
        }

        return view('pages.admin.keluhan.index', compact('keluhan', 'status'));
    }

    public function show($id_keluhan)
    {

        $keluhan = Keluhan::with(['kategori'])->where('id_keluhan', $id_keluhan)->first();

        $tanggapan = Tanggapan::where('id_keluhan', $id_keluhan)->first();

        $struktural = Struktural::all();

        return view('pages.admin.keluhan.show', [
            'keluhan' => $keluhan,
            'tanggapan' => $tanggapan,
            'struktural' => $struktural
        ]);
    }

    public function storeDisposisi(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'id_keluhan' => 'required|exists:keluhan,id_keluhan',
            'id_struktural' => 'required|exists:struktural,id_struktural',
            'pesan' => 'required|string|max: 500'
        ]);

        $keluhan = Keluhan::findOrFail($request->id_keluhan);

        if (!$keluhan) {
            return redirect()->back()->with('error', 'Keluhan tidak ditemukan.');
        }

        if (Auth::guard('admin')->user()->id_struktural != 1) {
            return redirect()->back()->with('error', 'Hanya Dekan yang dapat melakukan disposisi.');
        }

        $keluhan->id_struktural = $request->id_struktural;
        $keluhan->status = 'proses';
        $keluhan->save();

        Disposisi::create([
            'id_keluhan' => $request->id_keluhan,
            'id_struktural' => $request->id_struktural,
            'pesan' => $request->pesan,
        ]);
        return redirect()->back()->with('status', 'Disposisi berhasil dikirim.');
    }

    public function destroy(Request $request, $id_keluhan)
    {

        if ($id_keluhan = 'id_keluhan') {
            $id_keluhan = $request->id_keluhan;
        }

        $keluhan = Keluhan::find($id_keluhan);

        $keluhan->delete();

        if ($request->ajax()) {
            return 'success';
        }

        return redirect()->route('keluhan.index');
    }

    public function storeEvaluasi(Request $request)
    {
        $request->validate([
            'id_keluhan' => 'required|exists:keluhan,id_keluhan',
            'isi_evaluasi' => 'required|string'
        ]);

        Evaluasi::updateOrCreate(
            ['id_keluhan' => $request->id_keluhan],
            ['isi_evaluasi' => $request->isi_evaluasi]
        );

        return redirect()->back()->with('success', 'Evaluasi Berhasil disimpan!');
    }
}
