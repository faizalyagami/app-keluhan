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

class KeluhanController extends Controller
{

    public function index($status)
    {
        $keluhan = Keluhan::where('status', $status)->orderBy('tgl_keluhan', 'desc')->get();

        $loggedPetugas = Auth::guard('petugas')->user();

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

    // public function storeDisposisi(Request $request)
    // {
    //     $request->validate([
    //         'id_keluhan' => 'required|exists:keluhan,id_keluhan',
    //         'id_struktural' => 'required|exists:struktural,id_struktural',
    //         'pesan' => 'required|string|max: 225'
    //     ]);

    //     Disposisi::create([
    //         'id_keluhan' => $request->id_keluhan,
    //         'id_struktural' => $request->id_struktural,
    //         'pesan' => $request->pesan,
    //     ]);

    //     return redirect()->back()->with('status', 'Disposisi Berhasil dikirim');
    // }

    public function storeDisposisi(Request $request)
    {
        $request->validate([
            'id_keluhan' => 'required|exists:keluhan,id_keluhan',
            'id_struktural' => 'required|exists:struktural,id_struktural',
            'pesan' => 'required|string|max: 500'
        ]);

        $keluhan = Keluhan::findOrFail($request->id_keluhan);
        // $idStruktural = StrukturalHelper::getIdByStrukturalById(1);

        // if ($keluhan->id_struktural == $this->$idStruktural) {
        //     $keluhan->id_struktural = $request->id_struktural;
        //     $keluhan->save();
        if ($keluhan->id_struktural != 1) {
            return redirect()->back()->with('error', 'Disposisi  hanya dapat dilakukan oleh Dekan.');
        }

        $keluhan->id_struktural = $request->id_struktural;
        // $keluhan->status = 'disposisi';
        $keluhan->save();

        Disposisi::create([
            'id_keluhan' => $request->id_keluhan,
            'id_struktural' => $request->id_struktural,
            'pesan' => $request->pesan,
        ]);
        return redirect()->back()->with('status', 'Disposisi berhasil dikirim.');
    }
}
