@extends('layouts.app')

@section('title', 'Ubah Password')

@section('content')
    <!-- Header -->
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
          <div class="header-body">
            <div class="row align-items-center py-4">
              <div class="col-lg-6 col-7">
                <h6 class="h2 text-white d-inline-block mb-0">Ubah Password</h6>
                <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                  <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                    <li class="breadcrumb-item"><a href="{{ route('keluhan') }}">Keluhan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Ubah Password</li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
        </div>
    </div>
    
    <!-- Page content -->
    <div class="container mt-6"> <!-- Ganti container-fluid dengan container untuk membatasi lebar -->
        <div class="row justify-content-center">
            <div class="col-md-6"> <!-- Menentukan lebar form -->
                <div class="card mt-5 mb-5">
                    <div class="card-header">
                        <h3 class="mb-0">Form Ubah Password</h3>
                    </div>
                    <div class="card-body">
                        <!-- Form Ubah Password -->
                        <form action="{{ route('keluhan.setting.password.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label for="old_password" class="form-label">Password Lama</label>
                                <input type="password" class="form-control" id="old_password" name="old_password">
                                @error('old_password')
                                    <small class="form-text" style="color: red; font-style: italic;">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password Baru</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                @error('password')
                                    <small class="form-text" style="color: red; font-style: italic;">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                @error('password_confirmation')
                                    <small class="form-text" style="color: red; font-style: italic;">{{ $message }}</small>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Ubah Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
