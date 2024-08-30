@extends('dashboard.menu')

@section('content')
  <main class="col-md-9 ms-sm-5 col-lg-8 px-md-1">
    @if (session()->has('success'))    
    <div class="alert alert-info alert-dismissible fade show col-md-12 mt-4" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Form Digitalisasi Dokumen Naskah</h1>
      </div>
      <form class="row g-3 mb-5 mt-4" action="/naskah/{{ $naskah->id }}/edit" method="post" enctype="multipart/form-data">
        @method('put')
        @csrf
        <div class="col-md-5">
            <label for="judul" class="form-label">Judul Naskah</label>
            <input type="text" name="judul" class="form-control" id="judul" value="{{ old('judul', $naskah->judul) }}">
            @error('judul')    
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
        </div>
        <div class="col-md-5">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" id="tangal" value="{{ old('tanggal', $naskah->tanggal) }}">
            @error('tanggal')    
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
        </div>
        <div class="image">
          <a href="{{ asset('storage/'. $naskah->dokumen_naskah) }}" target="blank">
            <img src="{{ asset('storage/'. $naskah->dokumen_naskah) }}" alt="Dokumen tersimpan" class="img-fluid" style="height: 100px">
          </a>
        </div>
        <div class="input-group mb-3 col-5">
          <input type="file" class="form-control" id="oldDokumen_naskah" value="{{ $naskah->dokumen_naskah }}" name="oldDokumen_naskah" hidden>
          <input type="file" class="form-control" id="dokumen_naskah" name="dokumen_naskah">
          <label class="input-group-text @error('dokumen_naskah') is-invalid @enderror" required for="dokumen_naskah">Upload Dokumen Naskah</label>
          @error('dokumen_naskah')    
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
        </div>
        <div class="col-12 mt-3">
            <button type="submit" class="btn btn-primary">Kirim File</button>
        </div>
            {{-- <a href="/naskah">Kembali</a> --}}
        </form>
  </main>
      
@endsection