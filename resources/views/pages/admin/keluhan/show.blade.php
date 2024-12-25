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
                <h6 class="h2 text-white d-inline-block mb-0">Tanggapan</h6>
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
                            <td>{{ $keluhan->isi_keluhan }}</td>
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
                          <th>Bukti Keluhan</th>
                          <td>:</td>
                          <td><img src="{{ Storage::url($keluhan->foto) }} " class="card-img"></td>
                        </tr>
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
          <div class="col-xl-6 order-xl-2">
            <div class="card">
              <div class="card-header">
                <div class="row align-items-center">
                  <div class="col-8">
                    <h3 class="mb-0">Tanggapan</h3>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <form action="{{ route('tanggapan')}} " method="POST">
                    @csrf
                    <input type="hidden" name="id_keluhan" value="{{ $keluhan->id_keluhan }}">
                  <!-- Tanggapan -->
                  <div class="">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" class="form-control" id="status">
                            @if ($keluhan->status == '0')
                                <option selected value="0">Pending</option>
                                <option value="proses">Proses</option>
                                <option value="selesai">Selesai</option>
                            @elseif($keluhan->status == 'proses')
                                <option value="0">Pending</option>
                                <option selected value="proses">Proses</option>
                                <option value="selesai">Selesai</option>
                            @else
                                <option value="0">Pending</option>
                                <option value="proses">Proses</option>
                                <option selected value="selesai">Selesai</option>
                            @endif
                        </select>
                      </div>
                    <div class="form-group">
                      <label class="form-control-label">Tanggapan</label>
                      <textarea rows="4" class="form-control" name="tanggapan" id="tanggapan" placeholder="Ketik tanggapan">{{ $tanggapan->tanggapan ?? '' }}</textarea>
                    </div>
                  </div>

                  <button type="submit" class="btn btn-primary">Kirim</button>
                </form>
              </div>
            </div>
          </div>

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
                <form action="{{ route('tanggapan')}} " method="POST">
                    @csrf
                    <input type="hidden" name="id_keluhan" value="{{ $keluhan->id_keluhan }}">
                  <!-- Tanggapan -->
                  <div class="">
                    <div class="form-group">
                        <label for="status">Disposisi kepada</label>
                        <select name="id_struktural" id="struktural" class="form-control @error('') is-invalid @enderror" required>
                    <option value="">--Pilih tujuan--</option>
                    @foreach ($struktural as $item)
                        <option value="{{ $item->id_struktural }}">{{ $item->nama_struktural }}</option>
                    @endforeach
                </select>
                      </div>
                    <div class="form-group">
                      <label class="form-control-label">Pesan</label>
                      <textarea rows="2" class="form-control" name="tanggapan" id="tanggapan" placeholder="Ketik pesan">{{ $tanggapan->tanggapan ?? '' }}</textarea>
                    </div>
                  </div>

                  <button type="submit" class="btn btn-primary">Kirim</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection

@push('addon-script')
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#keluhanTable').DataTable();
    } );
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
@endpush
