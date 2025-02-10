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
                        <h6 class="h2 text-white d-inline-block mb-0">Keluhan</h6>
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
                    <!-- Card header -->
                    <div class="card-header border-0">
                        <h3 class="mb-0">Data Keluhan</h3>
                    </div>

                    <!-- Light table -->
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush" id="keluhanTable">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="sort" data-sort="no">No</th>
                                    <th scope="col" class="sort" data-sort="tanggal">Tanggal</th>
                                    <th scope="col" class="sort" data-sort="name">Nama</th>
                                    <th scope="col" class="sort" data-sort="name">Keluhan ditujukan</th>
                                    <th scope="col" class="sort" data-sort="isi">Isi Keluhan</th>
                                    <th scope="col" class="sort" data-sort="status">Status</th>
                                    <th scope="col" class="sort" data-sort="action">Aksi</th>
                                    @if ($keluhan->contains('status', 'selesai') && Auth::user()->roles === 'admin')
                                        <th scope="col" class="sort" data-sort="action">Evaluasi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="list">
                                @foreach($keluhan as $k => $v)
                                    <tr>
                                        <td class="budget">
                                            <span class="text-sm">{{ $k + 1 }}</span>
                                        </td>
                                        <td>
                                            <span class="text-sm">{{ \Carbon\Carbon::parse($v->tgl_keluhan)->format('d-m-Y') }}</span>
                                        </td>
                                        <td><span class="text-sm">{{ $v->user->name }}</span></td>
                                        <td>
                                            <span class="text-sm">{{ $v->struktural->nama_struktural ?? 'Tidak ditemukan' }}</span>
                                        </td>
                                        <td class="text-break" title="{{ $v->isi_keluhan }}">
                                            <span class="text-sm">{{ substr($v->isi_keluhan, 0, 30) }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($v->status == '0')
                                                    <span class="text-sm badge badge-danger">Pending</span>
                                                @elseif($v->status == 'proses')
                                                    <span class="text-sm badge badge-warning">Proses</span>
                                                @elseif($v->status == 'disposisi')
                                                    <span class="text-sm badge badge-info">Disposisi</span>
                                                @else
                                                    <span class="text-sm badge badge-success">Selesai</span>
                                                @endif
                                            </div>
                                        </td>
                                        @if ($status == '0')
                                            <td>
                                                <a href="#" data-id_keluhan="{{ $v->id_keluhan }}" class="btn btn-primary keluhan">Verifikasi</a>
                                                <a href="#" data-id_keluhan="{{ $v->id_keluhan }}" class="btn btn-danger keluhanDelete">Hapus</a>
                                            </td>
                                        @else
                                            <td><a href="{{ route('keluhan.show', $v->id_keluhan) }}" class="btn btn-info">Lihat</a></td>
                                        @endif
                                        <td>
                                          @if ($v->status == 'selesai' && Auth::user()->roles === 'admin')
                                              <a href="#" data-id_keluhan="{{ $v->id_keluhan }}" data-bs-toggle="modal" data-bs-target="#evaluasiModal{{ $v->id_keluhan }}" class="btn btn-warning">Lihat</a>
                                              @if($v->first_evaluasi)
                                                  <span class="text-sm badge badge-success">Sudah di evaluasi</span>
                                              @else
                                                  <span class="text-sm badge badge-danger">Belum di evaluasi</span>
                                              @endif
                                          @endif
                                      </td> 
                                    </tr>

                                    <!-- Modal for Evaluasi -->
                                    @foreach ($keluhan as $v)
                                        @if ($v->status == 'selesai')
                                          <div class="modal fade" id="evaluasiModal{{ $v->id_keluhan }}" tabindex="-1" aria-labelledby="evaluasiModal" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="evaluasiModal">Evaluasi Keluhan {{ $v->id_keluhan }}</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>{{ $v->firstEvaluasi->isi_evaluasi ?? 'Belum ada evaluasi' }}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        @endif
                                    @endforeach
                                    
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Card footer -->
                    <div class="card-footer py-4">
                        <nav aria-label="...">
                            <ul class="pagination justify-content-end mb-0">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">
                                        <i class="fas fa-angle-left"></i>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">
                                        <i class="fas fa-angle-right"></i>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
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
    });
</script>

<script>
    $(document).on('click', '.keluhan', function (e) {
        e.preventDefault();
        let id_keluhan = $(this).data('id_keluhan');
        Swal.fire({
            title: 'Peringatan!',
            text: "Apakah Anda yakin akan memverifikasi keluhan?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28B7B5',
            confirmButtonText: 'OK',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: '{{ route('tanggapan') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id_keluhan": id_keluhan,
                        "status": "proses",
                        "tanggapan": ''
                    },
                    success: function (response) {
                        if (response == 'success') {
                            Swal.fire({
                                title: 'Pemberitahuan!',
                                text: "keluhan berhasil diverifikasi!",
                                icon: 'success',
                                confirmButtonColor: '#28B7B5',
                                confirmButtonText: 'OK',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                } else {
                                    location.reload();
                                }
                            });
                        }
                    },
                    error: function (data) {
                        Swal.fire({
                            title: 'Pemberitahuan!',
                            text: "keluhan gagal diverifikasi!",
                            icon: 'error',
                            confirmButtonColor: '#28B7B5',
                            confirmButtonText: 'OK',
                        });
                    }
                });
            } else {
                Swal.fire({
                    title: 'Pemberitahuan!',
                    text: "keluhan gagal diverifikasi!",
                    icon: 'error',
                    confirmButtonColor: '#28B7B5',
                    confirmButtonText: 'OK',
                });
            }
        });
    });

    $(document).on('click', '.keluhanDelete', function (e) {
        e.preventDefault();
        let id_keluhan = $(this).data('id_keluhan');
        Swal.fire({
            title: 'Peringatan!',
            text: "Apakah Anda yakin akan menghapus keluhan?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28B7B5',
            confirmButtonText: 'OK',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: '{{ route('keluhan.delete', 'id_keluhan') }}'.replace('id_keluhan', id_keluhan),
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id_keluhan": id_keluhan,
                    },
                    success: function (response) {
                        if (response == 'success') {
                            Swal.fire({
                                title: 'Pemberitahuan!',
                                text: "keluhan berhasil dihapus!",
                                icon: 'success',
                                confirmButtonColor: '#28B7B5',
                                confirmButtonText: 'OK',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                } else {
                                    location.reload();
                                }
                            });
                        }
                    },
                    error: function (data) {
                        Swal.fire({
                            title: 'Pemberitahuan!',
                            text: "keluhan gagal dihapus!",
                            icon: 'error',
                            confirmButtonColor: '#28B7B5',
                            confirmButtonText: 'OK',
                        });
                    }
                });
            } else {
                Swal.fire({
                    title: 'Pemberitahuan!',
                    text: "keluhan gagal dihapus!",
                    icon: 'error',
                    confirmButtonColor: '#28B7B5',
                    confirmButtonText: 'OK',
                });
            }
        });
    });
</script>
@endpush
