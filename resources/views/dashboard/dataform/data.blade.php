@extends('layouts.main')
@section('container')
@if (auth()->user()->role == 'user')
  <main class="col-md-9 ms-sm-5 col-lg-9 px-md-1">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-1 mb-1 border-bottom">
        <h1 class="h2">Form Permintaan Aplikasi</h1>
      </div>
      <form class="row g-3 mb-5 mt-2" action="/data" method="post" enctype="multipart/form-data">
        @if (session()->has('success'))    
    <div class="alert alert-info alert-dismissible fade show col-md-10" role="alert">
      <strong>Selamat </strong>{{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
        @endif
        @csrf
        <div class="col-md-5 visually-hidden">
            <label for="user_id" class="form-label">id user</label>
            <input type="number" name="user_id" class="form-control" id="user_id" readonly value="{{ auth()->user()->id }}">
        </div>
        <div class="col-md-5">
            <label for="perihal" class="form-label">Perihal</label>
            <input type="text" name="perihal" class="form-control @error('perihal') is-invalid @enderror" required value="{{ old('perihal') }}" id="perihal">
            @error('perihal')    
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
        </div>
        <div class="col-md-5">
            <label for="tanggal" class="form-label">Tanggal Permintaan</label>
            <input type="date" name="tanggal" class="form-control" id="tangal" value="{{ old('no') }}">
            @error('tanggal')    
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
        </div>
        {{-- ini bagian satuker --}}
        
        {{-- <div class="col-md-5">
            <label for="satker" class="form-label">Satker</label>
            <input type="text" name="satker" class="form-control @error('satker') is-invalid @enderror" required value="{{ old('satker') }}" id="satker">
            @error('satker')    
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
        </div> --}}

        {{-- ini bagian akhir satuker --}}

        {{-- <div class="col-md-5">
            <label for="status" class="form-label">Status</label>
            <input type="text" name="status" class="form-control @error('status') is-invalid @enderror" required value="{{ old('status') }}" id="status">
            @error('status')    
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
        </div> --}}
        {{-- <div class="col-md-5">
            <label for="status" class="form-label">status</label>
            <select id="status" name="status" class="form-select" value="{{ old('status') }}">
                <option selected>Pilih...</option>
                <option value="proses">Proses</option>
                <option value="belum">Belum Proses</option>
                <option value="selesai">Selesai</option>
                </select>            
        </div> --}}
        <div class="col-5">
            <label for="tujuan" class="form-label">Tujuan</label>
            <input type="text" name="tujuan" class="form-control @error('tujuan') is-invalid @enderror" required value="{{ old('tujuan') }}" id="tujuan">
            @error('tujuan')    
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
        </div>
        <div class="input-group mb-3 col-5">
          {{-- <img class="preview img-fluid" src="#"> --}}
          <input type="file" class="form-control" id="image" name="image" >
          <label class="input-group-text @error('image') is-invalid @enderror" required for="image">Upload Proposal</label>
          @error('image')    
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
        </div>
        {{-- <div class="col-5">
            <label for="file" class="form-label">Link File</label>
            <input type="url" name="file" class="form-control @error('judul') is-invalid @enderror" value="{{ old('file') }}" id="file">
            @error('file')    
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
        </div> --}}
        <div class="col-12 mt-5">
            <button type="submit" class="btn btn-primary">Kirim File</button>
        </div>
        </form>
  </main>
  @endif

  <script>
    // function previewImage(event){
    //   var input = event.target;
    //   var reader = new FileReader();

    //   reader.onload = function(){
    //     var preview = document.getElementById('preview');
    //     preview.src = reader.result;
    //     preview.style.display = 'block';
    //   };

    //   reader.readAsDataURL(input.files[0]);
    // }
  </script>

      
        @endsection