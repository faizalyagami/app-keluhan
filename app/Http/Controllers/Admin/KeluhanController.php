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

        $keluhan = Keluhan::with(['kategori', 'evaluasi', 'struktural', 'firstEvaluasi'])
            ->where('status', $status)
            ->when($loggedPetugas->roles == 'petugas', function ($q) use ($loggedPetugas) {
                $strukturalMapping = [
                    'Dr. Dewi Sartika, M.Si' => ['Dekan Fakultas'],
                    'Dr. Siti Qodariah, M.Psi.' => ['Bidang Akademik S1'],
                    'Farida Coralia, S.Psi., M.Psi.' => ['Bidang Akademik S1'],
                    'Dr. Eneng Nurlaili Wangi, M.Psi.' => ['Bidang Akademik Profesi'],
                    'Dr. Endah Nawangsih, Dra., M.Psi.' => ['Bidang Akademik Profesi'],
                    'Dr. Lilim Halimah, BHSc., MHSPY.' => ['Bidang Administrasi Umum dan Keuangan'],
                    'Nurmariam' => ['Bidang Administrasi Umum dan Keuangan'],
                    'Suhana, S.Psi., M.Psi.' => ['Bidang Kemahasiswaan'],
                    'Undang Kamaludin' => ['Bidang Kemahasiswaan'],
                    'Rizka Hadian Permana, S.Psi., M.Psi.' => ['Laboratorium Psikologi'],
                    'Ali Mubarak, S.Psi., M.Psi.' => ['Bidang Akademik S1', 'Bidang Akademik Profesi'],
                    'Nida Hamidah, S.Psi' => ['Bidang Akademik S1', 'Bidang Akademik Profesi'],
                ];

                if (isset($strukturalMapping[$loggedPetugas->nama_petugas])) {
                    $q->whereHas('struktural', function ($query) use ($strukturalMapping, $loggedPetugas) {
                        $query->whereIn('nama_struktural', $strukturalMapping[$loggedPetugas->nama_petugas]);
                    });
                }
            })
            ->orderBy('tgl_keluhan', 'desc')
            ->paginate(10);

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
