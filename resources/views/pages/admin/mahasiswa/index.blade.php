@extends('layouts.admin')
@section('title', 'Mahasiswa')

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
                <h6 class="h2 text-white d-inline-block mb-0">Mahasiswa</h6>
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
              <div class="card-header border-0 d-flex justify-content-between">
                <h3 class="mb-0">Data Mahasiswa</h3>
                  <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                      Tambah Mahasiswa
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                      <li><a class="dropdown-item" href="{{ route('mahasiswa.create') }}"><i class="bi bi-person-add me-2"></i>Tambah Manual</a></li>
                      <li><a class="dropdown-item" href="{{ route('mahasiswa.download.format') }}"><i class="bi bi-download me-2"></i>Unduh Format</a></li>
                      <li><a class="dropdown-item" href="#" id="importOption"><i class="bi bi-file-earmark-arrow-up me-2"></i>Import</a></li>
                    </ul>
                  </div>
              </div>
              <!-- Light table -->
              <div class="table-responsive">
                <table class="table align-items-center table-flush" id="mahasiswaTable">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col">No</th>
                      <th scope="col">NPM</th>
                      <th scope="col">Nama</th>
                      <th scope="col">Username</th>
                      <th scope="col">No Telpon</th>
                      <th scope="col">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach($mahasiswa as $index => $mhs)
                      <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $mhs->npm }}</td>
                        <td>{{ $mhs->name }}</td>
                        <td>{{ $mhs->username }}</td>
                        <td>{{ $mhs->telp }}</td>
                        <td>
                            <a href="{{ route('mahasiswa.show', $mhs->npm) }}" class="btn btn-sm btn-info">Detail</a>
                            <a href="#" data-npm="{{ $mhs->npm }}" class="btn btn-sm btn-danger mahasiswaDelete">Hapus</a>
                        </td>
                      </tr>
                      @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal untuk Import Data -->
      <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="importModalLabel">Import Data Mahasiswa</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="{{ route('mahasiswa.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                  <label for="file" class="form-label">Pilih File</label>
                  <input type="file" class="form-control" name="file" id="file" required>
                </div>
                <button type="submit" class="btn btn-primary">Import</button>
              </form>
            </div>
          </div>
        </div>
      </div>
@endsection

@push('addon-script')
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#mahasiswaTable').DataTable();
    });

    // Handle Delete Action
    $(document).on('click', '.mahasiswaDelete', function (e) {
    e.preventDefault();
    let npm = $(this).data('npm');
    Swal.fire({
        title: 'Peringatan!',
        text: "Apakah Anda yakin akan menghapus mahasiswa?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#28B7B5',
        confirmButtonText: 'OK',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "DELETE",
                url: `{{ route('mahasiswa.destroy', '') }}/${npm}`,
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function (response) {
                    if (response.status === 'success') {
                        Swal.fire('Pemberitahuan!', 'Mahasiswa berhasil dihapus!', 'success').then(() => {
                            location.reload();
                        });
                    }
                },
                error: function () {
                    Swal.fire('Pemberitahuan!', 'Mahasiswa gagal dihapus!', 'error');
                }
            });
        }
    });
});

    // Modal Import Handler
    $('#importOption').click(function() {
        var myModal = new bootstrap.Modal(document.getElementById('importModal'));
        myModal.show();
    });
</script>
@endpush
