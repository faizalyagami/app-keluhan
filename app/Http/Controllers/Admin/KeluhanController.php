<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keluhan;
use App\Models\Struktural;
use App\Models\Tanggapan;
use Illuminate\Support\Facades\Auth;

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
}
