@extends('layouts.app')

@section('title', 'Keluhan')

@section('content')
<main id="main" class="martop">

    <section class="inner-page">
      <div class="container ">
        <div class="row">
            <div class="col-md-4">
                <div class="card card-responsive p-4 border-0 shadow rounded mx-auto">
                    <h5><b>Data Pelapor Keluhan</b></h5>
               </div>
            </div>
            <div class="col-md-8">
                <div class="card card-responsive p-4 border-0 shadow rounded mx-auto text-center">
                    <img src="{{ $keluhan->foto }}" alt="">
                    <h3>{{ $keluhan->kategori_keluhan }}</h3>
                    <p>
                        @if($keluhan->status == '0')
                            <span class="text-sm text-white p-1 bg-danger">Pending</span>
                        @elseif($keluhan->status == 'proses')
                            <span class="text-sm text-white p-1 bg-warning">Proses</span>
                        @else
                            <span class="text-sm text-white p-1 bg-success">Selesai</span>
                        @endif
                    </p>
                    <p>{{ $keluhan->isi_keluhan }}</p>
                    <span class="text-sm badge badge-warning">Proses</span>
               </div>
            </div>
        </div>



      </div>
    </section>

  </main><!-- End #main -->
@endsection

<!-- @push('addon-script')
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
@endpush -->
