@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
<main id="main" class="martop">

    <section class="inner-page">
      <div class="container ">
        <div class="title text-center mb-5">
            <h1 class="fw-bold">Keluhan Saya</h1>
        </div>
        <div class="keluhan">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @forelse($keluhan as $i)
                <div class="col">
                    <div class="card h-100">
                      {{-- <img src="{{ Storage::url($i->foto) }}" class="card-img-top" alt="..."> --}}
                      <div class="card-body">
                        <h5 class="card-title"><b>{{ $i->kategori->nama_kategori_keluhan ?? 'Kategori tidak ditemukan'}}</b></h5>
                        <p class="card-text">{{ $i->isi_keluhan }}</p>
                          <a href="{{ route('keluhan.detail', $i->id_keluhan) }}" class="btn btn-primary">Detail</a>
                      </div>
                    </div>
                  </div>
                @empty
                @endforelse
              </div>
        </div>

      </div>
    </section>

  </main><!-- End #main -->
@endsection
