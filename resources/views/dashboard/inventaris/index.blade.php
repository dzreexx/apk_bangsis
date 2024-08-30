@extends('dashboard.menu')
@section('content')
<main class="col-md-9 ms-sm-5 col-lg-8 px-md-1">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Form Inventaris Bangsis</h1>
    </div>
    <form class="row g-3 mb-5 mt-1" action="/inventaris-input" method="post">
      @if (session()->has('success'))    
  <div class="alert alert-info alert-dismissible fade show col-md-10" role="alert">
    <strong>Selamat </strong>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif
      @csrf
      {{-- <div class="col-md-5 visually-hidden">
          <label for="nama" class="form-label">Nama </label>
          <input type="number" name="user_id" class="form-control" id="user_id" readonly value="{{ auth()->user()->id }}">
      </div> --}}
      <div class="col-md-5">
          <label for="barang" class="form-label">Nama Barang</label>
          <input type="text" name="barang" class="form-control @error('barang') is-invalid @enderror" required value="{{ old('barang') }}" id="barang">
          @error('barang')    
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
      </div>
      <div class="col-md-5">
          <label for="serial" class="form-label">Serial Number</label>
          <input type="text" name="serial" class="form-control @error('serial') is-invalid @enderror" id="serial" value="{{ old('serial') }}">
          @error('serial')    
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
      </div>
      <div class="col-md-5">
        <label for="jenisBarang" class="form-label">Jenis Barang</label>
        <select id="jenisBarang" name="jenisBarang" class="form-select">
            <option selected>Pilih...</option>
            <option value="pc">PC</option>
            <option value="monitor">Monitor</option>
            <option value="tv">TV</option>
            <option value="printer">Printer</option>
            <option value="lain">lain..</option>
        </select>
        @error('jenisBarang')    
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
    </div>

    <div class="col-md-5" id="customJenisField" style="display: none;">
        <label for="customJenis" class="form-label">Jenis Barang Lain</label>
        <input type="text" name="customJenis" class="form-control" id="customJenis">
    </div>

      {{-- <div class="col-md-5 " id="muncul" style="display: none;">
        <label for="serial" class="form-label">Serial Number</label>
        <input type="text" name="serial" class="form-control" id="serial" value="{{ old('serial') }}">
        @error('serial')    
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
    </div> --}}
      <div class="col-5">
          <label for="merk" class="form-label">Merk</label>
          <input type="text" name="merk" class="form-control @error('merk') is-invalid @enderror" required value="{{ old('merk') }}" id="merk">
          @error('merk')    
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
      </div>
      <div class="col-5">
          <label for="tanggal" class="form-label">Tanggal Pembuatan</label>
          <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" required value="{{ old('tanggal') }}" id="tanggal">
          @error('tanggal')    
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
      </div>
      <div class="col-md-5">
        <label for="kondisi" class="form-label">Kondisi</label>
        <select id="kondisi" name="kondisi" class="form-select" value="{{ old('kondisi') }}">
            <option selected>Pilih...</option>
            <option value="baik">Baik</option>
            <option value="rusak ringan">Rusak Ringan</option>
            <option value="rusak berat">Rusak Berat</option>
            </select>            
    </div>
      <div class="col-12 mt-5">
          <button type="submit" class="btn btn-primary">Kirim File</button>
      </div>
      </form>
      <script>
        document.getElementById('jenisBarang').addEventListener('change', function () {
            var customJenisField = document.getElementById('customJenisField');
            var customJenisInput = document.getElementById('customJenis');
    
            if (this.value === 'lain') {
                customJenisField.style.display = 'block';
                customJenisInput.required = true;
            } else {
                customJenisField.style.display = 'none';
                customJenisInput.required = false;
            }
        });
    </script>

@endsection