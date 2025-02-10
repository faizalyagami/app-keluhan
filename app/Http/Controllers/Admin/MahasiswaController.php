<?php

namespace App\Http\Controllers\Admin;

use App\Models\Mahasiswa;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Exports\MahasiswaExport;
use App\Imports\MahasiswaImport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;

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

    public function create()
    {
        return view('pages.admin.mahasiswa.create');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'npm' => 'required|unique:mahasiswa,npm|max:11',
            'name' => 'required|max:50',
            'email' => 'required|email|unique:mahasiswa,email',
            'username' => 'required|unique:mahasiswa,username|max:50',
            'jenis_kelamin' => 'required',
            'telp' => ['required', 'regex:/^628\d{6,15}$/'],
            'alamat' => 'required|string'
        ], [
            'email.email' => 'Format email yang dimasukkan tidak valid.',
            'telp.regex' => 'Nomor telepon harus diawali dengan 628 diikuti dengan 6 hingga 11 digit angka.'
        ]);

        $password = Hash::make($request->npm);

        // Mahasiswa::create([
        //     'npm' => $request->npm,
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'username' => $request->username,
        //     'jenis_kelamin' => $request->jenis_kelamin,
        //     'telp' => $request->telp,
        //     'alamat' => $request->alamat
        // ]);

        $mahasiswa = new Mahasiswa();
        $mahasiswa->npm = $request->npm;
        $mahasiswa->name = $request->name;
        $mahasiswa->email = $request->email;
        $mahasiswa->email_verified_at = now();
        $mahasiswa->username = $request->username;
        $mahasiswa->jenis_kelamin = $request->jenis_kelamin;
        $mahasiswa->telp = $request->telp;
        $mahasiswa->alamat = $request->alamat;
        $mahasiswa->password = $password;

        // Simpan ke dalam database
        $mahasiswa->save();

        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan.');
    }

    public function destroy($npm)
    {

        // Cari mahasiswa berdasarkan npm
        $mahasiswa = Mahasiswa::where('npm', $npm)->first();

        // Jika mahasiswa tidak ditemukan
        if (!$mahasiswa) {
            return redirect()->route('mahasiswa.index')->with('error', 'Mahasiswa tidak ditemukan.');
        }

        // Hapus mahasiswa
        $mahasiswa->delete();

        // Respon untuk AJAX atau biasa
        if (request()->ajax()) {
            return response()->json(['status' => 'success', 'message' => 'Mahasiswa berhasil dihapus']);
        }

        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil dihapus.');
    }

    public function downloadFormat()
    {
        $headers = [
            'NPM',
            'Name',
            'Email',
            'Username',
            'Jenis Kelamin',
            'No Telp',
            'Alamat',
        ];

        $data = [$headers];

        return Excel::download(new class($data) implements FromArray {
            private $data;

            public function __construct(array $data)
            {
                $this->data = $data;
            }

            public function array(): array
            {
                return $this->data;
            }
        }, 'format_tambah_mahasiswa.xls');
    }

    public function import(Request $request)
    {
        set_time_limit(300);

        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new MahasiswaImport, $request->file('file'));

        $mahasiswa = Mahasiswa::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Data Mahasiswa berhasil di import',
            'data' => $mahasiswa
        ]);
    }
}
