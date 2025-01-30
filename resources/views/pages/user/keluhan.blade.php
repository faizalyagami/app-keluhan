@extends('layouts.app')

@section('title', 'Keluhan')

@section('content')
<main id="main" class="martop">

    <section class="inner-page">
      <div class="container ">
        <div class="title text-center mb-5">
            {{-- <h2 class="text-center">Assalamualaikum {{ $mahasiswa->name }}, buatkan keluhanmu!</h2> --}}
            <h3 class="fw-bold">Layanan Keluhan</h3>
            <h5 class="fw-normal">Sampaikan keluhan Anda langsung kepada yang berwenang</h5>
        </div>
       <div class="card card-responsive p-4 border-0 col-md-8 shadow rounded mx-auto">
        <form action="{{ route('keluhan.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <label for="id_struktural" class="form-label">Keluhan ditujukan kepada :</label>
                <select name="id_struktural" id="struktural" class="form-control @error('') is-invalid @enderror" required>
                    <option value="">--Pilih tujuan--</option>
                    @foreach ($struktural as $item)
                        <option value="{{ $item->id_struktural }}">{{ $item->nama_struktural }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="kategori_keluhan" class="form-label">Kategori Keluhan</label>
                <select name="kategori_keluhan" id="kategori_keluhan" class="form-control @error('kategori_keluhan') is-invalid @enderror" required onchange="checkKategoriKeluhan()">
                    <option value="">--Pilih Kategori Keluhan--</option>
                    @foreach ($kategoriKeluhan as $kategori)
                        <option value="{{ $kategori->id_kategori_keluhan }}">{{ $kategori->nama_kategori_keluhan }}</option>
                    @endforeach
                    <option value="lain">Lain-lain</option>
                </select>
            </div>
            <!-- Input teks untuk 'Lain-lain' -->
            <div class="form-group mb-3" id="input-lain" style="display: none;">
                <label for="lain_keluhan">Tulis Kategori Keluhan</label>
                <input type="text" class="form-control @error('lain_keluhan') is-invalid @enderror" id="lain_keluhan" name="lain_keluhan" placeholder="Masukkan keluhan Anda">
                @error('lain_keluhan')
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
                <input type="file" name="foto[]" id="foto" class="form-control @error('foto') is-invalid @enderror" multiple>
                @error('foto')
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
                } else {
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
                } else {
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

    <script>
        function checkKategoriKeluhan() {
            const kategoriSelect = document.getElementById('kategori_keluhan');
            const inputLain = document.getElementById('input-lain');

            // Tampilkan input jika "Lain-lain" dipilih
            if (kategoriSelect.value === 'lain') {
                inputLain.style.display = 'block';
            } else {
                inputLain.style.display = 'none';
            }
        }
    </script>
@endpush
