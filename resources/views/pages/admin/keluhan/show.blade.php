@extends('layouts.admin')
@section('title', 'Keluhan')


@push('addon-style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
@endpush
@section('content')
    <!-- Header -->
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
          <div class="header-body">
            <div class="row align-items-center py-4">
              <div class="col-lg-6 col-7">
                <h6 class="h2 text-white d-inline-block mb-0">Tindak Lanjut</h6>
                <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                  {{-- <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Lihat</li>
                    <li class="breadcrumb-item"><a href="#">Tanggapan</a></li>
                  </ol> --}}
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="row">
          <div class="col-xl-12 order-xl-1">
            <div class="card">
              <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                <h3>Data Keluhan</h3>
              </div>
              <div class="card-body">
                <table class="table">
                    <tbody>
                        <tr>
                            <th>NPM</th>
                            <td>:</td>
                            <td>{{ $keluhan->npm }}</td>
                        </tr>
                        <tr>
                            <th>Keluhan ditujukan kepada</th>
                            <td>:</td>
                            <td>{{ $keluhan->struktural->nama_struktural }}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>:</td>
                            <td>{{ $keluhan->user->name }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Keluhan</th>
                            <td>:</td>
                            <td>{{ \Carbon\Carbon::parse($keluhan->tgl_keluhan)->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <th>Kategori Keluhan</th>
                            <td>:</td>
                            <td>{{ $keluhan->kategori->nama_kategori_keluhan }}</td>
                        </tr>
                        <tr>
                            <th>Isi Keluhan</th>
                            <td>:</td>
                            <td style="word-wrap: break-word; max-width: 200px; white-space: normal;">{{ $keluhan->isi_keluhan }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>:</td>
                            <td>
                                @if($keluhan->status == '0')
                                    <span class="text-sm badge badge-danger">Pending</span>
                                @elseif($keluhan->status == 'proses')
                                    <span class="text-sm badge badge-warning">Proses</span>
                                @else
                                    <span class="text-sm badge badge-success">Selesai</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                          <th>Status Disposisi</th>
                          <td>:</td>
                          <td>
                            @if ($keluhan->status == 'proses' && $keluhan->disposisi->where('id_keluhan', $keluhan->id_keluhan)->count() > 0)
                              <span class="text-sm badge badge-info">Disposisi</span>
                            @else
                              <span class="text-sm badge badge-danger">-</span>
                            @endif
                          </td>
                        </tr>
                        <tr>
                          <th>Pesan Disposisi</th>
                          <td>:</td>
                          <td>
                            @if ($keluhan->status == 'proses' && $keluhan->disposisi->where('id_keluhan', $keluhan->id_keluhan)->count() > 0)
                              {{ $keluhan->disposisi->firstWhere('id_keluhan', $keluhan->id_keluhan)?->pesan ?? '-' }}
                            @endif
                          </td>
                        </tr>
                        <tr>
                          <th>Bukti Keluhan</th>
                          <td>:</td>
                          <td>
                              @if ($keluhan->photos->isEmpty())
                                  <span class="text-sm badge badge-danger">- Tidak ada bukti keluhan -</span>
                              @else
                                  <a href="#" data-toggle="modal" data-target="#buktiKeluhanModal">
                                      <i class="bi bi-eye-fill" style="font-size:24px"></i>
                                  </a>
                              @endif
                          </td>
                      </tr>

                      <div class="modal fade" id="buktiKeluhanModal" tabindex="-1" aria-labelledby="buktiKeluhanLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="buktiKeluhanLabel">Bukti Keluhan</h5>
                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        @foreach($keluhan->photos as $foto)
                                            <div class="col-4">
                                                <!-- Link gambar untuk Lightbox -->
                                                <a href="{{ Storage::url($foto->path) }}" data-toggle="lightbox" data-gallery="gallery">
                                                    <img src="{{ Storage::url($foto->path) }}" alt="Bukti Keluhan" class="img-fluid mb-3">
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                        {{-- <tr>
                            <th>Hapus keluhan</th>
                            <td>:</td>
                            <td><a href="#" class="btn btn-danger keluhan">Hapus</a></td>
                        </tr> --}}
                    </tbody>
                </table>
              </div>
            </div>
          </div>

          @if ($keluhan->status != 'selesai')
          <div class="col-xl-6 order-xl-2">
            <div class="card">
              <div class="card-header">
                <div class="row align-items-center">
                  <div class="col-8">
                    <h3 class="mb-0">Tindak Lanjut</h3>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <form action="{{ route('tanggapanEmail')}} " method="POST">
                    @csrf
                    <input type="hidden" name="id_keluhan" value="{{ $keluhan->id_keluhan }}">
                  <!-- Tanggapan -->
                  <div class="">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" class="form-control" id="status">
                            @if ($keluhan->status == '0')
                                <option selected value="0">Belum Terselesaikan</option> {{--  pending --}}
                                <option value="proses">Diperlukan Tindak Lanjut Lain</option> {{--  proses --}}
                                <option value="selesai">Terselesaikan</option> {{--  selesai --}}
                            @elseif($keluhan->status == 'proses')
                                <option value="0">Belum Terselesaikan</option>
                                <option selected value="proses">Diperlukan Tindak Lanjut Lain</option>
                                <option value="selesai">Terselesaikan</option>
                            @else
                                <option value="0">Belum Terselesaikan</option>
                                <option value="proses">Diperlukan Tindak Lanjut Lain</option>
                                <option selected value="selesai">Terselesaikan</option>
                            @endif
                        </select>
                      </div>
                    <div class="form-group">
                      <label class="form-control-label">Tindak Lanjut</label>
                      <textarea rows="4" class="form-control" name="tanggapan" id="tanggapan" placeholder="Ketik tanggapan">{{ $tanggapan->tanggapan ?? '' }}</textarea>
                    </div>
                  </div>

                  <button type="submit" class="btn btn-primary">Kirim</button>
                </form>
              </div>
            </div>
          </div>
          @endif

          @if ($keluhan->status == 'selesai' && Auth::user()->roles === 'admin')
          <div class="col-xl-6 order-xl-2">
            <div class="card">
              <div class="card-header">
                <div class="row align-items-center">
                  <div class="col-8">
                    <h3 class="mb-0">Evaluasi</h3>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <form action="{{ route('evaluasi')}} " method="POST">
                    @csrf
                    <input type="hidden" name="id_keluhan" value="{{ $keluhan->id_keluhan }}">
                  <!-- Evaluasi -->
                  <div class="">
                    <div class="form-group">
                      <label class="form-control-label">Evaluasi</label>
                      <textarea rows="4" class="form-control" name="isi_evaluasi" id="evaluasi" placeholder="masukan evaluasi"></textarea>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary">Kirim</button>
                </form>
              </div>
            </div>
          </div>
          @endif

          @if ($keluhan->status != 'selesai' && Auth::guard('admin')->user()->id_petugas == 2 || Auth::guard('admin')->user()->id_petugas == 1)
            <div class="col-xl-6 order-xl-2">
              <div class="card">
                <div class="card-header">
                  <div class="row align-items-center">
                    <div class="col-8">
                      <h3 class="mb-0">Disposisi</h3>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <form action="{{ route('disposisi') }}" method="POST">
                      @csrf
                      <input type="hidden" name="id_keluhan" value="{{ $keluhan->id_keluhan }}">
                    <!-- Tanggapan -->
                    <div class="">
                      <div class="form-group">
                          <label for="status">Disposisi kepada</label>
                          <select name="id_struktural" id="struktural" class="form-control @error('id_struktural') is-invalid @enderror" required>
                            <option value="">--Pilih tujuan--</option>
                            @foreach ($struktural as $item)
                                <option value="{{ $item->id_struktural }}" {{ old('id_struktural') == $item->id_struktural ? 'selected' : '' }}>{{ $item->nama_struktural }}</option>
                            @endforeach
                          </select>
                            @error('id_struktural')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                      </div>
                      <div class="form-group">
                        <label class="form-control-label">Pesan</label>
                        <textarea rows="2" class="form-control" name="pesan" id="pesan" placeholder="Ketik pesan">{{ old('pesan') }}</textarea>
                      </div>
                          @error('pesan')
                            <span class="invalid-feedback">{{ $message }}</span>
                          @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Kirim</button>
                  </form>
                </div>
              </div>
            </div>  
          @endif
          
        </div>
      </div>
@endsection

@push('addon-script')
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#keluhanTable').DataTable();
    });

    // Handle form submission for evaluation
    $('#evaluasiForm').on('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        // Ajax form submission
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                Swal.fire({
                    title: 'Pemberitahuan!',
                    text: "Evaluasi berhasil dikirim.",
                    icon: 'success',
                    confirmButtonColor: '#28B7B5',
                    confirmButtonText: 'OK',
                }).then(function() {
                    location.reload();  // Reload the page after the popup
                });
            },
            error: function() {
                Swal.fire({
                    title: 'Error!',
                    text: "Terjadi kesalahan saat mengirim evaluasi.",
                    icon: 'error',
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'OK',
                });
            }
        });
    });
</script>

@if (session()->has('status'))
<script>
    Swal.fire({
        title: 'Pemberitahuan!',
        text: "{{ Session::get('status') }}",
        icon: 'success',
        confirmButtonColor: '#28B7B5',
        confirmButtonText: 'OK',
    });
</script>
@endif

@if (session()->has('error'))
<script>
    Swal.fire({
        title: 'Error!',
        text: "{{ Session::get('error') }}",
        icon: 'error',
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'OK',
    });
</script>

<script>
  $(document).ready(function () {
      // Inisialisasi Lightbox untuk gambar yang di-klik
      $(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
          event.preventDefault();
          $(this).ekkoLightbox();
      });
  });
</script>
@endif
@endpush
