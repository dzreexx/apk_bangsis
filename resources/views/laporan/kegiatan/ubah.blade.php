@extends('dashboard.menu')

@section('content')
<main class="col-md-9 ms-sm-5 col-lg-8 px-md-1">
    {{-- <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Form Laporan Kegiatan</h1>
    </div> --}}
  {{-- <main class="col-md-9 ms-sm-5 col-lg-8 px-md-1"> --}}
    @if (session()->has('success'))    
    <div class="alert alert-info alert-dismissible fade show col-md-12 mt-4" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Form Laporan Kegiatan</h1>
      </div>
      <form class="row g-3 mb-5 mt-4" action="/kegiatan/{{ $kegiatan->id }}/edit" method="post" enctype="multipart/form-data">
        @method('put')
        @csrf
        <div class="col-md-5">
            <label for="nama" class="form-label">Judul Kegiatan</label>
            <input type="text" name="nama" class="form-control" id="nama" value="{{ old('nama', $kegiatan->nama) }}">
        </div>
        <div class="col-md-5">
            <label for="tanggal" class="form-label">Tanggal Kegiatan</label>
            <input type="date" name="tanggal" class="form-control" id="tangal" value="{{ old('tanggal', $kegiatan->tanggal) }}">
            @error('tanggal')    
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
        </div>
        <div class="col-md-5">
            <label for="personel" class="form-label">Personel</label>
            <input type="text" name="personel" class="form-control @error('personel') is-invalid @enderror" required value="{{ old('personel', $kegiatan->personel) }}" id="personel">
            @error('personel')    
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
        </div>
        <div class="col-5">
            <label for="kegiatan" class="form-label">Kegiatan</label>
            <input type="text" name="kegiatan" class="form-control @error('kegiatan') is-invalid @enderror" required value="{{ old('kegiatan', $kegiatan->kegiatan) }}" id="kegiatan">
            @error('kegiatan')    
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
        </div>
        <div class="image">
          
          <a href="{{ asset('storage/'.$kegiatan->bukti) }}" target="blank-page"><img src="{{ asset('storage/'.$kegiatan->bukti) }}" alt="" class="img-fluid w-25"></a>
          {{-- <a href="{{ asset('storage/'.$kegiatan->bukti) }}" target="blank-page"><img src="{{ asset('storage/'.$kegiatan->buktiDua) }}" alt="" class="img-fluid w-25"></a>
          <a href="{{ asset('storage/'.$kegiatan->bukti) }}" target="blank-page"><img src="{{ asset('storage/'.$kegiatan->buktiTiga) }}" alt="" class="img-fluid w-25"></a> --}}
        </div>
        <div class="input-group mb-3 col-5">
          <input type="file" class="form-control" id="oldBukti" name="oldBukti" hidden>
          <input type="file" class="form-control" id="bukti" name="bukti">
          <label class="input-group-text @error('bukti') is-invalid @enderror" required for="bukti">Upload Dokunen Kegiatan</label>
          @error('bukti')    
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
        </div>
        {{-- <div class="input-group mb-3 col-5">
          <input type="file" class="form-control" id="oldBuktiDua" name="oldBuktiDua" hidden>
          <input type="file" class="form-control" id="buktiDua" name="buktiDua">
          <label class="input-group-text @error('buktiDua') is-invalid @enderror" required for="buktiDua">Upload Dokunen Kegiatan</label>
          @error('buktiDua')    
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
        </div>
        <div class="input-group mb-3 col-5">
          <input type="file" class="form-control" id="oldBuktiTiga" name="oldBuktiTiga" hidden>
          <input type="file" class="form-control" id="buktiTiga" name="buktiTiga">
          <label class="input-group-text @error('buktiTiga') is-invalid @enderror" required for="buktiTiga">Upload Dokunen Kegiatan</label>
          @error('buktiTiga')    
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
        </div> --}}
        <div class="col-12 mt-3">
            <button type="submit" class="btn btn-primary">Kirim File</button>
        </div>
            {{-- <a href="/kegiatan">Kembali</a> --}}
        </form>
  </main>
      
@endsection