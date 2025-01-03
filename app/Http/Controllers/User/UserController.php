<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\VerifikasiEmailUntukRegistrasiKeluhanMahasiswa;
use App\Models\KategoriKeluhan;
use App\Models\Keluhan;
use App\Models\Mahasiswa;
use App\Models\Petugas;
use App\Models\Province;
use App\Models\Struktural;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;

class UserController extends Controller
{


    public function index()
    {
        $keluhan = Keluhan::count();
        $proses = Keluhan::where('status', 'proses')->count();
        $selesai = Keluhan::where('status', 'selesai')->count();

        return view('home', [
            'keluhan' => $keluhan,
            'proses' => $proses,
            'selesai' => $selesai,
        ]);
    }

    // public function tentang()
    // {
    //     return view('pages.user.about');
    // }

    public function keluhan()
    {
        $keluhan = Keluhan::get();
        $struktural = Struktural::all();
        $kategoriKeluhan = KategoriKeluhan::all();
        return view('pages.user.keluhan', compact('keluhan', 'struktural', 'kategoriKeluhan'));
    }

    public function masuk()
    {
        return view('pages.user.login');
    }

    public function login(Request $request)
    {

        $data = $request->all();

        $validate = Validator::make($data, [
            'username' => ['required'],
            'password' => ['required']
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        if (filter_var($request->username, FILTER_VALIDATE_EMAIL)) {

            $email = Mahasiswa::where('email', $request->username)->first();

            if (!$email) {
                return redirect()->back()->with(['pesan' => 'Email tidak terdaftar']);
            }

            $password = Hash::check($request->password, $email->password);


            if (!$password) {
                return redirect()->back()->with(['pesan' => 'Password tidak sesuai']);
            }

            if (Auth::guard('mahasiswa')->attempt(['email' => $request->username, 'password' => $request->password])) {

                return redirect()->route('keluhan');
            } else {

                return redirect()->back()->with(['pesan' => 'Akun tidak terdaftar!']);
            }
        } else {

            $mahasiswa = Mahasiswa::where('username', $request->username)->first();

            $petugas = Petugas::where('username', $request->username)->first();

            if ($mahasiswa) {
                $username = Mahasiswa::where('username', $request->username)->first();

                if (!$username) {
                    return redirect()->back()->with(['pesan' => 'Username tidak terdaftar']);
                }

                $password = Hash::check($request->password, $username->password);

                if (!$password) {
                    return redirect()->back()->with(['pesan' => 'Password tidak sesuai']);
                }

                if (Auth::guard('mahasiswa')->attempt(['username' => $request->username, 'password' => $request->password])) {

                    return redirect()->route('keluhan');
                } else {

                    return redirect()->back()->with(['pesan' => 'Akun tidak terdaftar!']);
                }
            } elseif ($petugas) {
                $username = Petugas::where('username', $request->username)->first();

                if (!$username) {
                    return redirect()->back()->with(['pesan' => 'Username tidak terdaftar']);
                }

                $password = Hash::check($request->password, $username->password);

                if (!$password) {
                    return redirect()->back()->with(['pesan' => 'Password tidak sesuai']);
                }

                if (Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password])) {

                    return redirect()->route('dashboard');
                } else {

                    return redirect()->back()->with(['pesan' => 'Akun tidak terdaftar!']);
                }
            } else {
                return redirect()->back()->with(['pesan' => 'Akun tidak terdaftar!']);
            }
        }
    }

    public function register()
    {
        $provinces = Province::all();
        return view('pages.user.register', compact('provinces'));
    }

    public function register_post(Request $request)
    {
        $data = $request->all();

        $validate = Validator::make($data, [
            'npm' => ['required', 'min:16', 'max:16', 'unique:mahasiswa'],
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'string', 'unique:mahasiswa'],
            'username' => ['required', 'string', 'regex:/^\S*$/u', 'unique:mahasiswa', 'unique:petugas,username'],
            'jenis_kelamin' => ['required'],
            'password' => ['required', 'min:6'],
            'telp' => ['required', 'regex:/(08)[0-9]/'],
            'alamat' => ['required'],
            'rt' => ['required'],
            'rw' => ['required'],
            'kode_pos' => ['required'],
            'province_id' => ['required'],
            'regency_id' => ['required'],
            'district_id' => ['required'],
            'village_id' => ['required'],
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        Mahasiswa::create([
            'npm' => $data['npm'],
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => strtolower($data['username']),
            'jenis_kelamin' => $data['jenis_kelamin'],
            'password' => Hash::make($data['password']),
            'telp' => $data['telp'],
            'alamat' => $data['alamat'],
            'email_verified_at' => Carbon::now(),
            'rt' => $data['rt'],
            'rw' => $data['rw'],
            'kode_pos' => $data['kode_pos'],
            'province_id' => $data['province_id'],
            'regency_id' => $data['regency_id'],
            'district_id' => $data['district_id'],
            'village_id' => $data['village_id'],
        ]);

        $mahasiswa = Mahasiswa::where('email', $data['email'])->first();

        Auth::guard('mahasiswa')->login($mahasiswa);

        return redirect('/keluhan');
    }

    public function logout()
    {
        Auth::guard('mahasiswa')->logout();

        return redirect('/login');
    }

    public function storeKeluhan(Request $request)
    {
        if (!Auth::guard('mahasiswa')->check()) {
            return redirect()->back()->with(['keluhan' => 'Login dibutuhkan!', 'type' => 'error']);
        } elseif (Auth::guard('mahasiswa')->user()->email_verified_at == null && Auth::guard('mahasiswa')->user()->telp_verified_at == null) {
            return redirect()->back()->with(['keluhan' => 'Akun belum diverifikasi!', 'type' => 'error']);
        }

        $data = $request->all();

        $validate = Validator::make($data, [
            'kategori_keluhan' => ['required', 'exists:kategori_keluhan,id_kategori_keluhan'],
            'isi_keluhan' => ['required'],
            'id_struktural' => ['required', 'exists:struktural,id_struktural'],
            //'tgl_keluhan' => ['required'],
            // 'id_kategori' => ['required'],
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }


        if ($request->file('foto')) {
            $data['foto'] = $request->file('foto')->store('assets/keluhan', 'public');
        }

        date_default_timezone_set('Asia/Bangkok');

        $keluhan = Keluhan::create([
            'tgl_keluhan' => date('Y-m-d h:i:s'),
            'npm' => Auth::guard('mahasiswa')->user()->npm,
            'kategori_keluhan' => $data['kategori_keluhan'],
            'isi_keluhan' => $data['isi_keluhan'],
            'id_struktural' => $data['id_struktural'],
            //'tgl_keluhan' => $data['tgl_keluhan'],
            // 'id_kategori' => $data['id_kategori'],
            'foto' => $data['foto'] ?? 'assets/keluhan/tambakmekar.png',
            'status' => '0',
        ]);

        if ($keluhan) {

            return redirect()->back()->with(['keluhan' => 'Berhasil terkirim!', 'type' => 'success']);
        } else {

            return redirect()->back()->with(['keluhan' => 'Gagal terkirim!', 'type' => 'error']);
        }
    }

    public function laporan($who = '')
    {
        $terverifikasi = Keluhan::where([['npm', Auth::guard('mahasiswa')->user()->npm], ['status', '!=', '0']])->get()->count();
        $proses = Keluhan::where([['npm', Auth::guard('mahasiswa')->user()->npm], ['status', 'proses']])->get()->count();
        $selesai = Keluhan::where([['npm', Auth::guard('mahasiswa')->user()->npm], ['status', 'selesai']])->get()->count();

        $hitung = [$terverifikasi, $proses, $selesai];

        if ($who == 'saya') {

            $keluhan = Keluhan::where('npm', Auth::guard('mahasiswa')->user()->npm)->orderBy('tgl_keluhan', 'desc')->get();

            return view('pages.user.laporan', ['keluhan' => $keluhan, 'hitung' => $hitung, 'who' => $who]);
        } else {

            $keluhan = Keluhan::where('status', '!=', '0')->orderBy('tgl_keluhan', 'desc')->get();

            return view('pages.user.laporan', ['keluhan' => $keluhan, 'hitung' => $hitung, 'who' => $who]);
        }
    }

    public function detailkeluhan($id_keluhan)
    {
        $keluhan = Keluhan::where('id_keluhan', $id_keluhan)->first();

        return view('pages.user.detail', ['keluhan' => $keluhan]);
    }

    public function laporanEdit($id_keluhan)
    {
        $keluhan = Keluhan::where('id_keluhan', $id_keluhan)->first();

        return view('user.edit', ['keluhan' => $keluhan]);
    }

    public function laporanUpdate(Request $request, $id_keluhan)
    {
        $data = $request->all();

        $validate = Validator::make($data, [
            'kategori_keluhan' => ['required'],
            'isi_keluhan' => ['required'],
            //'tgl_keluhan' => ['required'],
            // 'id_kategori' => ['required'],
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        if ($request->file('foto')) {
            $data['foto'] = $request->file('foto')->store('assets/keluhan', 'public');
        }

        $keluhan = Keluhan::where('id_keluhan', $id_keluhan)->first();

        $keluhan->update([
            'kategori_keluhan' => $data['kategori_keluhan'],
            'isi_keluhan' => $data['isi_keluhan'],
            //'tgl_keluhan' => $data['tgl_keluhan'],
            // 'id_kategori' => $data['kategori_kejadian'],
            'foto' => $data['foto'] ?? $keluhan->foto
        ]);

        return redirect()->route('pekat.detail', $id_keluhan);
    }

    public function laporanDestroy(Request $request)
    {
        $keluhan = Keluhan::where('id_keluhan', $request->id_keluhan)->first();

        $keluhan->delete();

        return 'success';
    }


    public function password()
    {
        return view('user.password');
    }

    public function updatePassword(Request $request)
    {
        $data = $request->all();

        if (Auth::guard('mahasiswa')->user()->password == null) {
            $validate = Validator::make($data, [
                'password' => ['required', 'min:6', 'confirmed'],
            ]);
        } else {
            $validate = Validator::make($data, [
                'old_password' => ['required', 'min:6'],
                'password' => ['required', 'min:6', 'confirmed'],
            ]);
        }

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        $npm = Auth::guard('mahasiswa')->user()->npm;

        $mahasiswa = Mahasiswa::where('npm', $npm)->first();

        if (Auth::guard('mahasiswa')->user()->password == null) {
            $mahasiswa->password = Hash::make($data['password']);
            $mahasiswa->save();

            return redirect()->back()->with(['pesan' => 'Password berhasil diubah!', 'type' => 'success']);
        } elseif (Hash::check($data['old_password'], $mahasiswa->password)) {

            $mahasiswa->password = Hash::make($data['password']);
            $mahasiswa->save();

            return redirect()->back()->with(['pesan' => 'Password berhasil diubah!', 'type' => 'success']);
        } else {
            return redirect()->back()->with(['pesan' => 'Password lama salah!', 'type' => 'error']);
        }
    }

    public function ubah(Request $request, $what)
    {
        if ($what == 'email') {
            $mahasiswa = Mahasiswa::where('npm', $request->npm)->first();

            $mahasiswa->email = $request->email;
            $mahasiswa->save();

            return 'success';
        } elseif ($what == 'telp') {

            $validate = Validator::make($request->all(), [
                'telp' => ['required', 'regex:/(08)[0-9]/'],
            ]);

            if ($validate->fails()) {
                return 'error';
            }

            $mahasiswa = Mahasiswa::where('npm', $request->npm)->first();

            $mahasiswa->telp = $request->telp;
            $mahasiswa->save();

            return 'success';
        }
    }

    public function profil()
    {
        $npm = Auth::guard('mahasiswa')->user()->npm;

        $mahasiswa = Mahasiswa::where('npm', $npm)->first();

        return view('user.profil', ['mahasiswa' => $mahasiswa]);
    }

    public function updateProfil(Request $request)
    {
        $npm = Auth::guard('mahasiswa')->user()->npm;

        $data = $request->all();

        $validate = Validator::make($data, [
            'npm' => ['sometimes', 'required', 'min:16', 'max:16', Rule::unique('mahasiswa')->ignore($npm, 'npm')],
            'nama' => ['required', 'string'],
            'email' => ['sometimes', 'required', 'email', 'string', Rule::unique('mahasiswa')->ignore($npm, 'npm')],
            'username' => ['sometimes', 'required', 'string', 'regex:/^\S*$/u', Rule::unique('mahasiswa')->ignore($npm, 'npm'), 'unique:petugas,username'],
            'jenis_kelamin' => ['required'],
            'telp' => ['required', 'regex:/(08)[0-9]/'],
            'alamat' => ['required'],
            'rt' => ['required'],
            'rw' => ['required'],
            'kode_pos' => ['required'],
            'province_id' => ['required'],
            'regency_id' => ['required'],
            'district_id' => ['required'],
            'village_id' => ['required'],
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        $mahasiswa = Mahasiswa::where('npm', $npm);

        $mahasiswa->update([
            'npm' => $data['npm'],
            'nama' => $data['nama'],
            'email' => $data['email'],
            'username' => strtolower($data['username']),
            'jenis_kelamin' => $data['jenis_kelamin'],
            'telp' => $data['telp'],
            'alamat' => $data['alamat'],
            'rt' => $data['rt'],
            'rw' => $data['rw'],
            'kode_pos' => $data['kode_pos'],
            'province_id' => $data['province_id'],
            'regency_id' => $data['regency_id'],
            'district_id' => $data['district_id'],
            'village_id' => $data['village_id'],
        ]);
        return redirect()->back()->with(['pesan' => 'Profil berhasil diubah!', 'type' => 'success']);
    }
}
