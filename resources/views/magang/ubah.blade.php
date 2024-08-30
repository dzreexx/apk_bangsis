@extends('dashboard.menu')

@section('content')
<main class="col-md-9 ms-sm-5 col-lg-8 px-md-1">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Ubah Data Magang Mahasiswa</h1>
    </div>
<form class="row g-3 mb-5" action="/magang/{{ $magang->id }}/edit" method="post" enctype="multipart/form-data" >
    @if (session()->has('success'))    
    <div class="alert alert-info alert-dismissible fade show col-md-12 mt-5" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @method('put')
    @csrf
    {{-- <h4 class="text-center mt-5">Form Magang Mahasiswa</h4> --}}
    <div class="col-md-6">
        <label for="name" class="form-label">Nama</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" required value="{{ old('name', $magang->name) }}">
        @error('name')    
            <div class="invalid-feedback">
            {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="nim" class="form-label">NIM</label>
        <input type="number" name="nim" class="form-control @error('nim') is-invalid @enderror" id="nim" required value="{{ old('nim', $magang->nim) }}">
        @error('nim')    
            <div class="invalid-feedback">
            {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="univ" class="form-label">Universitas</label>
        <input type="text" name="univ" class="form-control @error('univ') is-invalid @enderror" id="univ" required value="{{ old('univ', $magang->univ) }}">
        @error('univ')    
            <div class="invalid-feedback">
            {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="dateStart" class="form-label">Tanggal Mulai Magang</label>
        <input type="date" name="dateStart" class="form-control @error('dateStart') is-invalid @enderror" id="tangal" required value="{{ old('dateStart', $magang->dateStart) }}">
        @error('dateStart')    
            <div class="invalid-feedback">
            {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="dateEnd" class="form-label">Tanggal Selesai Magang</label>
        <input type="date" name="dateEnd" class="form-control @error('dateEnd') is-invalid @enderror" id="tangal" required value="{{ old('dateEnd', $magang->dateEnd) }}">
        @error('dateEnd')    
            <div class="invalid-feedback">
            {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="judul" class="form-label">Judul Laporan</label>
        <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" id="judul" required value="{{ old('judul', $magang->judul) }}">
        @error('judul')    
            <div class="invalid-feedback">
            {{ $message }}
            </div>
        @enderror
    </div>
    <div class="dok">
        <a href="{{ asset('storage/'. $magang->laporan) }}" target="blank_page" class="text-decoration-none">lihat laporan</a>
    </div>
    <div class="input-group mb-3 col-5">
        <input type="file" class="form-control" id="oldLaporan" name="oldLaporan" hidden>
        <input type="file" class="form-control" id="laporan" name="laporan">
        <label class="input-group-text @error('laporan') is-invalid @enderror" required for="laporan">Dokumen Laporan</label>
        @error('laporan')    
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
      </div>
    <div class="col-12">
        <button type="submit" class="btn btn-primary">Kirim Data</button>
    </div>
        {{-- <a href="/magang">Kembali</a> --}}
    </form>
@endsection