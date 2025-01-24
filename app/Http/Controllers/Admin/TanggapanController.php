<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Keluhan;
use App\Models\Tanggapan;

class TanggapanController extends Controller
{
    public function response(Request $request)
    {

        $keluhan = Keluhan::where('id_keluhan', $request->id_keluhan)->first();

        $tanggapan = Tanggapan::where('id_keluhan', $request->id_keluhan)->first();

        if ($tanggapan) {
            $keluhan->update(['status' => $request->status]);

            $tanggapan->update([
                'tgl_tanggapan' => date('Y-m-d'),
                'tanggapan' => $request->tanggapan ?? '',
                'id_petugas' => Auth::guard('admin')->user()->id_petugas,
            ]);

            if ($request->ajax()) {
                return 'success';
            }

            return redirect()->route('keluhan.show', ['id_keluhan' => $request->id_keluhan, 'keluhan' => $keluhan, 'tanggapan' => $tanggapan])->with(['status' => 'Berhasil Ditanggapi!']);
        } else {
            $keluhan->update(['status' => $request->status]);

            $tanggapan = Tanggapan::create([
                'id_keluhan' => $request->id_keluhan,
                'tgl_tanggapan' => date('Y-m-d'),
                'tanggapan' => $request->tanggapan ?? '',
                'id_petugas' => Auth::guard('admin')->user()->id_petugas,
            ]);

            if ($request->ajax()) {
                return 'success';
            }

            return redirect()->route('keluhan.show', ['id_keluhan' => $request->id_keluhan, 'keluhan' => $keluhan, 'tanggapan' => $tanggapan])->with(['status' => 'Berhasil Ditanggapi!']);
        }
    }
}
