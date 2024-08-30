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
        <h1 class="h2">Form Rapat Nodin</h1>
      </div>
      <form class="row g-3 mb-5 mt-3" action="/nodin/tambah" method="post" enctype="multipart/form-data">
        @csrf
        @method('post')
        <div class="col-md-5">
            <label for="no" class="form-label">No Notadinas</label>
            <input type="number" name="no" class="form-control" id="no" value="{{ old('no') }}">
        </div>
        <div class="col-md-5">
            <label for="judul" class="form-label">Judul</label>
            <input type="text" name="judul" class="form-control" id="judul" value="{{ old('judul') }}">
        </div>
        <div class="col-md-5">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" id="tangal" value="{{ old('tanggal') }}">
            @error('tanggal')    
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
        </div>
        <div class="col-md-5">
            <label for="konseptor" class="form-label">Konseptor</label>
            <input type="text" name="konseptor" class="form-control @error('konseptor') is-invalid @enderror" required value="{{ old('konseptor') }}" id="konseptor">
            @error('konseptor')    
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
        </div>
        <div class="mb-3">
          <label for="keterangan" class="form-label">Keterangan</label>
          <textarea class="form-control" id="keterangan" required value="{{ old('keterangan') }}" name="keterangan" rows="3"></textarea>
          @error('keterangan')    
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
        </div>
        <div class="input-group mb-3 col-5">
          <input type="file" class="form-control" id="dokumen_nodin" name="dokumen_nodin">
          <label class="input-group-text @error('dokumen_nodin') is-invalid @enderror" required for="dokumen_nodin">Upload</label>
          @error('dokumen_nodin')    
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
        </div>
        <div class="col-12 mt-3">
            <button type="submit" class="btn btn-primary">Kirim File</button>
        </div>
          {{-- <a href="/nodin">Kembali</a> --}}
        </form>
  </main>
      
@endsection