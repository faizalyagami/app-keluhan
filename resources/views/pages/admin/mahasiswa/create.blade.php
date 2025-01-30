@extends('layouts.admin')
@section('title', 'Tambah Mahasiswa')

@section('content')
    <!-- Header -->
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
          <div class="header-body">
            <div class="row align-items-center py-4">
              <div class="col-lg-6 col-7">
                <h6 class="h2 text-white d-inline-block mb-0">Tambah Mahasiswa</h6>
                <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                  <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                    <li class="breadcrumb-item"><a href="{{ route('mahasiswa.index') }}">Mahasiswa</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Manual</li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Form Tambah Mahasiswa</h3>
                    </div>
                    <div class="card-body">
                        <!-- Form Tambah Manual -->
                        <form action="{{ route('mahasiswa.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="npm" class="form-label">NPM</label>
                                <input type="text" class="form-control" id="npm" name="npm" required>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <small class="form-text" style="color: red; font-style: italic;">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="telp" class="form-label">No Telpon</label>
                                <input type="text" class="form-control" id="telp" name="telp" required>
                                <small class="form-text text-muted" style="color: red; font-style: italic;">Format no tlp: 628xxxxxx</small>
                                @error('telp')
                                    <small class="form-text" style="color: red; font-style: italic;">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif