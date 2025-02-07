@extends('layouts.app')

@section('title', 'Ubah Profile')

@section('content')
    <!-- Header -->
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
          <div class="header-body">
            <div class="row align-items-center py-4">
              <div class="col-lg-6 col-7">
                <h6 class="h2 text-white d-inline-block mb-0">Ubah Profile</h6>
                <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                  <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                    <li class="breadcrumb-item"><a href="{{ route('keluhan') }}">Keluhan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Ubah Profile</li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
        </div>
    </div>

    <!-- Page content -->
    <div class="container mt-6">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5 mb-5">
                    <div class="card-header">
                        <h3 class="mb-0">Form Ubah Profile</h3>
                    </div>
                    <div class="card-body">
                        @php
                            $user = Auth::guard('mahasiswa')->user();
                        @endphp

                        @if ($user)
                            <!-- Form Ubah Profile -->
                            <form action="{{ route('keluhan.setting.profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $user->nama ?? '' }}" disabled>
                                </div>

                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" value="{{ $user->username ?? '' }}" disabled>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email ?? '' }}" required>
                                    @error('email')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="telp" class="form-label">Nomor Telepon</label>
                                    <input type="text" class="form-control" id="telp" name="telp" value="{{ $user->telp ?? '' }}" required>
                                    @error('telp')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat" required>{{ $user->alamat ?? '' }}</textarea>
                                    @error('alamat')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                        <option value="" disabled>Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki" {{ ($user->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ ($user->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </form>
                        @else
                            <p class="text-danger">Silakan login terlebih dahulu.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


