@extends('dashboard.menu')

@section('content')
<main class="col-md-9 ms-sm-5 col-lg-8 px-md-1">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Ubah Data Lapkonis</h1>
    </div>
<form class="row g-3 mb-5" action="/lapkonis/{{ $sisfo->id }}/edit" method="post" enctype="multipart/form-data" >
    @if (session()->has('success'))    
    <div class="alert alert-info alert-dismissible fade show col-md-10 mt-3" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @method('put')
    @csrf
    {{-- <h4 class="text-center mt-5">Form Lapkonis Sisfo</h4> --}}
    <div class="col-md-6">
        <label for="name" class="form-label">Nama Aplikasi</label>
        <input type="text" name="name" class="form-control" id="name" required value="{{ old('name', $sisfo->name) }}">
        @error('name')    
            <div class="invalid-feedback">
            {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="tanggal" class="form-label">Tanggal Pembuatan</label>
        <input type="date" name="tanggal" class="form-control" id="tangal" required value="{{ old('tanggal', $sisfo->tanggal) }}">
        @error('tanggal')    
            <div class="invalid-feedback">
            {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="klasifikasi" class="form-label">Klasifikasi</label>
        <input type="text" name="klasifikasi" class="form-control" id="klasifikasi" required value="{{ old('klasifikasi', $sisfo->klasifikasi) }}">
        @error('klasifikasi')    
            <div class="invalid-feedback">
            {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="lokasi" class="form-label">Lokasi</label>
        <input type="text" name="lokasi" class="form-control" id="lokasi" required value="{{ old('lokasi', $sisfo->lokasi) }}">
        @error('lokasi')    
            <div class="invalid-feedback">
            {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="kondisi" class="form-label">Kondisi</label>
        <select id="kondisi" name="kondisi" class="form-select">
            @if ($sisfo->kondisi == 'mati')
            <option selected value="mati">Mati</option>
            <option value="tidak">Tidak digunakan</option>
            <option value="hidup">Hidup</option>
            @elseif($sisfo->kondisi == 'tidak')
            <option selected value="tidak">Tidak digunakan</option>
            <option value="hidup">Hidup</option>
            <option value="mati">Mati</option>
            @else
            <option selected value="hidup">Hidup</option>
            <option value="mati">Mati</option>
            <option value="tidak">Tidak digunakan</option>
            @endif
            {{-- <option value="mati">Mati</option>
            <option value="tidak">Tidak digunakan</option>
            <option value="hidup">Hidup</option> --}}
            </select>            
    </div>
    <div class="col-6">
        <label for="satker" class="form-label">Satker Pengguna</label>
        <input type="text" name="satker" class="form-control" id="satker" required value="{{ old('satker', $sisfo->satker) }}">
        @error('satker')    
            <div class="invalid-feedback">
            {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="alamat" class="form-label">Alamat</label>
        <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" required value="{{ old('alamat', $sisfo->alamat) }}" name="alamat" rows="3">{{ $sisfo->alamat }}</textarea>
        @error('alamat')    
            <div class="invalid-feedback">
            {{ $message }}
            </div>
        @enderror
    </div>
    <div class="image">
        <a href="{{ asset('storage/'. $sisfo->upload) }}" target="blank">
            <img src="{{ asset('storage/'. $sisfo->upload) }}" alt="Dokumen Sebelumnya" class="img-fluid" style="height: 100px">
        </a>
    </div>
    <div class="input-group mb-3 col-5">
        <input type="file" class="form-control" id="oldUpload" value="{{ $sisfo->upload }}" name="oldUpload" hidden>
        <input type="file" class="form-control" id="upload" name="upload">
        <label class="input-group-text @error('upload') is-invalid @enderror" required for="upload">Upload Dokumen</label>
        @error('upload')    
            <div class="invalid-feedback">
            {{ $message }}
            </div>
            @enderror
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn-primary">Kirim Data</button>
    </div>
        {{-- <a href="/lapkonis">Kembali</a> --}}
    </form>
@endsection