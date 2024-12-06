<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;

class MahasiswaController extends Controller
{
    public function index()
    {

        $mahasiswa = Mahasiswa::all();

        return view('pages.admin.mahasiswa.index', compact('mahasiswa'));
    }

    public function show($npm)
    {

        $mahasiswa = Mahasiswa::where('npm', $npm)->first();

        return view('pages.admin.mahasiswa.show', compact('mahasiswa'));
    }

    public function destroy(Request $request, $npm)
    {

        if ($npm = 'npm') {
            $npm = $request->npm;
        }

        $mahasiswa = Mahasiswa::find($npm);

        $mahasiswa->delete();

        if ($request->ajax()) {
            return 'success';
        }

        return redirect()->route('mahasiswa.index');
    }
}
