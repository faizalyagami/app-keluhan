@extends('layouts.app')

@section('title', 'Keluhan')

@section('content')
<main id="main" class="martop">

    <section class="inner-page">
      <div class="container ">
        <div class="title text-center mb-5">
            <h3 class="fw-bold">Layanan Keluhan</h3>
            <h5 class="fw-normal">Sampaikan keluhan Anda langsung kepada yang berwenang</h5>
        </div>
       <div class="card card-responsive p-4 border-0 col-md-8 shadow rounded mx-auto">
        <form action="{{ route('keluhan.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <label for="judul_keluhan" class="form-label">Judul Keluhan</label>
                <input type="text" value="{{ old('judul_keluhan') }}" name="judul_keluhan" id="judul_keluhan"
                    placeholder="Ketik Judul Keluhan" class="form-control @error('judul_keluhan') is-invalid @enderror" required >
                @error('judul_keluhan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="isi_keluhan" class="form-label">Isi Keluhan</label>
                <textarea name="isi_keluhan" id="isi_keluhan"
                    placeholder="Ketik isi Keluhan" rows="5" class="form-control @error('isi_keluhan') is-invalid @enderror" required>{{ old('isi_keluhan') }}</textarea>
                @error('isi_keluhan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- <div class="form-group mb-3">
                <label for="tgl_keluhan" class="form-label">Tanggal Keluhan</label>
                <input type="date" value="{{ old('tgl_keluhan') }}" name="tgl_keluhan" id="tgl_keluhan"
                    placeholder="Tanggal Kejadian" class="form-control @error('tgl_keluhan') is-invalid @enderror" required
                    >
                @error('tgl_keluhan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div> --}}

            <div class="form-group mb-3">
                <label for="foto" class="form-label">Bukti Keluhan</label>
                <input type="file" name="foto" id="foto" class="form-control @error('file') is-invalid @enderror" required>
                @error('file')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">KIRIM</button>

        </form>
       </div>
      </div>
    </section>

  </main><!-- End #main -->
@endsection

@push('addon-script')
    @if (!auth('mahasiswa')->check())
        <script>
            Swal.fire({
                title: 'Peringatan!',
                text: "Anda harus login terlebih dahulu!",
                icon: 'warning',
                confirmButtonColor: '#28B7B5',
                confirmButtonText: 'Masuk',
                allowOutsideClick: false
                }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{{ route('user.masuk') }}';
                }else{
                    window.location.href = '{{ route('user.masuk') }}';
                }
                });
        </script>
    @elseif(auth('mahasiswa')->user()->email_verified_at == null && auth('mahasiswa')->user()->telp_verified_at == null)
        <script>
            Swal.fire({
                title: 'Peringatan!',
                text: "Akun belum diverifikasi!",
                icon: 'warning',
                confirmButtonColor: '#28B7B5',
                confirmButtonText: 'Ok',
                allowOutsideClick: false
                }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{{ route('user.masuk') }}';
                }else{
                    window.location.href = '{{ route('user.masuk') }}';
                }
                });
        </script>
    @endif

    @if (session()->has('keluhan'))
        <script>
            Swal.fire({
                title: 'Pemberitahuan!',
                text: '{{ session()->get('keluhan') }}',
                icon: '{{ session()->get('type') }}',
                confirmButtonColor: '#28B7B5',
                confirmButtonText: 'OK',
            });
        </script>
    @endif
@endpush
