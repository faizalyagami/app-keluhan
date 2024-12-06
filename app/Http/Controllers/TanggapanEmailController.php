<?php

namespace App\Http\Controllers;

use App\Mail\TanggapanEmail;
use App\Models\Keluhan;
use App\Models\Tanggapan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TanggapanEmailController extends Controller
{
    public function response(Request $request)
    {
        $keluhan = Keluhan::where('id_keluhan', $request->id_keluhan)->first();
        $tanggapan = Tanggapan::where('id_keluhan', $request->id_keluhan)->first();

        if ($tanggapan) {
            //Update status dan tanggapan jika sudah ada
            $keluhan->update(['status' => $request->status]);
            $tanggapan->update([
                'tgl_tanggapan' => now(),
                'tanggapan' => $request->tanggapan ?? '',
                'id_petugas' => Auth::guard('admin')->user()->id_petugas,
            ]);

            //kirim email kepada user
            Mail::to($keluhan->user->email)->send(new TanggapanEmail($keluhan, $request->tanggapan));

            if ($request->ajax()) {
                return 'success';
            }
            return redirect()->route('pages.admin.keluhan.show', ['id_keluhan' => $request->id_keluhan, 'keluhan' => $keluhan, 'tanggapan' => $tanggapan])
                ->with(['status' => 'Berhasil ditanggapi !']);
        } else {
            //buat tanggapan baru jika belum ada
            $keluhan->update(['status' => $request->status]);

            $tanggapan = Tanggapan::create([
                'id_keluhan' => $request->id_keluhan,
                'tgl_tanggapan' => now(),
                'tanggapan' => $request->tanggapan ?? '',
                'id_petugas' => Auth::guard('admin')->user->id_petugas
            ]);

            //Kirim email kepada user
            Mail::to($keluhan->user->email)->send(new TanggapanEmail($keluhan, $request->tanggapan));

            if ($request->ajax()) {
                return 'success';
            }
            return redirect()->route('pages.admin.keluhan.show', ['id_keluhan' => $request->id_keluhan, 'keluhan' => $keluhan, 'tanggapan' => $tanggapan])
                ->with(['status' => 'Berhasil Ditanggapi!']);
        }
    }
}
