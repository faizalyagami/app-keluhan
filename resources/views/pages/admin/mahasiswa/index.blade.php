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
                <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                  {{-- <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="#">Mahasiswa</a></li>
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
                <table class="table align-items-center table-flush" id="keluhanTable">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col" class="sort" data-sort="no">No</th>
                      <th scope="col" class="sort" data-sort="no">NPM</th>
                      <th scope="col" class="sort" data-sort="name">Nama</th>
                      <th scope="col" class="sort" data-sort="username">username</th>
                      <th scope="col" class="sort" data-sort="tlp">No Telpon</th>
                      <th scope="col" class="sort" data-sort="action">Aksi</th>
                    </tr>
                  </thead>
                  <tbody class="list">
                      @foreach($mahasiswa as $k => $mhs)

                      <tr>
                        <td class="budget">
                            <span class="text-sm">{{ $k += 1}}</span>
                        </td>
                        <td><span class="text-sm">{{ $mhs->npm}}</span></td>
                        <td><span class="text-sm">{{ $mhs->name}}</span></td>
                        <td><span class="text-sm">{{ $mhs->username}}</span></td>
                        <td><span class="text-sm">{{ $mhs->telp}}</span></td>
                        <td style="width: 100px;">
                            <a href="{{ route('mahasiswa.show', $mhs->npm)}}" class="btn btn-sm btn-info">Detail</a>
                            <a href="#" data-npm="{{ $mhs->npm }}" class="btn btn-sm btn-danger mahasiswaDelete">Hapus</a>
                        </td>
                      </tr>

                      @endforeach
                  </tbody>
                </table>
              </div>
              <!-- Card footer -->
              {{-- <div class="card-footer py-4">
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
              </div> --}}
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

<script>

    $(document).on('click', '#del', function(e) {
        let id = $(this).data('userId');
        console.log(id);
    });

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
                    url: '{{ route('mahasiswa.destroy', 'npm') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "npm": npm,
                    },
                    success: function (response) {
                        if (response == 'success') {
                            Swal.fire({
                                title: 'Pemberitahuan!',
                                text: "Mahasiswa berhasil dihapus!",
                                icon: 'success',
                                confirmButtonColor: '#28B7B5',
                                confirmButtonText: 'OK',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }else{
                                    location.reload();
                                }
                            });
                        }
                    },
                    error: function (data) {
                        Swal.fire({
                            title: 'Pemberitahuan!',
                            text: "Mahasiswa gagal dihapus!",
                            icon: 'error',
                            confirmButtonColor: '#28B7B5',
                            confirmButtonText: 'OK',
                        });
                    }
                });
            } else {
                Swal.fire({
                    title: 'Pemberitahuan!',
                    text: "Mahasiswa gagal dihapus!",
                    icon: 'error',
                    confirmButtonColor: '#28B7B5',
                    confirmButtonText: 'OK',
                });
            }
        });
    });

    $(document).ready(function() {
    $('#keluhanTable').DataTable({
        "paging": true,  // Aktifkan pagination
        "searching": true, // Aktifkan pencarian
        "ordering": true,  // Aktifkan pengurutan
        "info": true  // Tampilkan informasi tabel
    });
  });
</script>

<!-- Modal untuk Unggah File -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="importModalLabel">Import Data Mahasiswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Form Unggah File -->
        <form action="{{ route('mahasiswa.import') }}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <label for="file" class="form-label">Pilih File</label>
            <input type="file" class="form-control" name="file" id="file" required>
          </div>
          <button type="submit" class="btn btn-primary">Import</button>
        </form>
        <div class="progress mt-3" style="display: none;" id="progressBarContainer">
          <div class="progress-bar progress-bar-striped progress-bar-animated" 
               role="progressbar" 
               aria-valuenow="0" 
               aria-valuemin="0" 
               aria-valuemax="100" 
               style="width: 0%;" 
               id="progressBar">
          </div>
      </div>      
      </div>
    </div>
  </div>
</div>

<!-- JavaScript untuk menangani klik "Import" -->
<script>
  document.getElementById('importOption').addEventListener('click', function() {
    // Menampilkan modal saat tombol Import diklik
    var myModal = new bootstrap.Modal(document.getElementById('importModal'));
    myModal.show();
  });
</script>

<script>
  document.querySelector('#importModal form').addEventListener('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);

    // Tampilkan progress bar
    let progressBarContainer = document.getElementById('progressBarContainer');
    let progressBar = document.getElementById('progressBar');
    progressBarContainer.style.display = 'block';
    progressBar.style.width = '0%';
    progressBar.setAttribute('aria-valuenow', '0');

    fetch('{{ route('mahasiswa.import') }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => {
        // Simulasikan progress (karena fetch tidak mendukung progress secara langsung)
        let progress = 0;
        let interval = setInterval(() => {
            progress += 20; // Tingkatkan progress 20% setiap kali
            progressBar.style.width = `${progress}%`;
            progressBar.setAttribute('aria-valuenow', `${progress}`);
            if (progress >= 100) clearInterval(interval);
        }, 500); // Interval 500ms

        return response.json();
    })
    .then(data => {
        if (data.status === 'success') {
            Swal.fire({
                title: 'Berhasil!',
                text: data.message,
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                // Update tabel tanpa reload
                let tbody = document.querySelector('#keluhanTable tbody');
                tbody.innerHTML = ''; // Kosongkan tabel
                data.data.forEach((item, index) => {
                    let row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.npm}</td>
                            <td>${item.name}</td>
                            <td>${item.username}</td>
                            <td>${item.telp}</td>
                            <td style="width: 100px;">
                                <a href="{{ url('admin/mahasiswa/') }}/${item.npm}" class="btn btn-sm btn-info">Detail</a>
                                <a href="#" data-npm="${item.npm}" class="btn btn-sm btn-danger mahasiswaDelete">Hapus</a>
                            </td>
                        </tr>`;
                    tbody.innerHTML += row;
                });

                // Tutup modal
                var myModal = bootstrap.Modal.getInstance(document.getElementById('importModal'));
                myModal.hide();
            });
        } else {
            Swal.fire({
                title: 'Error!',
                text: 'Terjadi kesalahan saat mengimpor data.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    })
    .catch(error => {
        Swal.fire({
            title: 'Error!',
            text: 'Gagal mengunggah file.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        console.error('Error:', error);
    })
    .finally(() => {
        // Sembunyikan progress bar
        progressBarContainer.style.display = 'none';
    });
});

</script>

@endpush
