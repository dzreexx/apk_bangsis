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
        <h1 class="h2">Form Digitalisasi Dokumen Paparan</h1>
      </div>
      <form class="row g-3 mb-5 mt-5" action="/paparan/tambah" method="post" enctype="multipart/form-data">
        @csrf
        @method('post')
        <div class="col-md-5">
            <label for="judul" class="form-label">Judul Paparan</label>
            <input type="text" name="judul" class="form-control" id="judul" value="{{ old('judul') }}">
            @error('judul')    
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
        </div>
        <div class="col-md-5">
            <label for="tanggal" class="form-label">Tanggal Paparan</label>
            <input type="date" name="tanggal" class="form-control" id="tangal" value="{{ old('tanggal') }}">
            @error('tanggal')    
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
        </div>
        <div class="input-group mb-3 col-5">
          <input type="file" class="form-control" id="dokumen_paparan" name="dokumen_paparan">
          <label class="input-group-text @error('dokumen_paparan') is-invalid @enderror" required for="dokumen_paparan">Upload Dokumen Paparan</label>
          @error('dokumen_paparan')    
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
        </div>
        <div class="col-12 mt-5">
            <button type="submit" class="btn btn-primary">Kirim File</button>
        </div>
            {{-- <a href="/paparan">Kembali</a> --}}
        </form>
  </main>
      
@endsection