@extends('dashboard.menu')
@section('content')
<main class="col-md-9 ms-sm-5 col-lg-8 px-md-1">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Form Tambah Akun</h1>
    </div>
    <form class="row g-3 mb-5 mt-1" action="/pengguna/tambah" method="post">
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
          <label for="name" class="form-label">Nama</label>
          <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required autofocus value="{{ old('name') }}" id="name">
          @error('name')    
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
      </div>
      <div class="col-md-5">
          <label for="nrp" class="form-label">NRP</label>
          <input type="number" name="nrp" class="form-control @error('nrp') is-invalid @enderror" id="nrp" value="{{ old('nrp') }}">
          @error('nrp')    
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
      </div>
      <div class="col-md-5">
          <label for="pangkat" class="form-label">Pangkat</label>
          <input type="text" name="pangkat" class="form-control @error('pangkat') is-invalid @enderror" id="pangkat" value="{{ old('pangkat') }}">
          @error('pangkat')    
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
      </div>
      <div class="col-md-5">
          <label for="korp" class="form-label">Korp</label>
          <input type="text" name="korp" class="form-control @error('korp') is-invalid @enderror" id="korp" value="{{ old('korp') }}">
          @error('korp')    
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
      </div>
      <div class="col-md-5">
        <label for="role" class="form-label">Peran</label>
        <select id="role" name="role" class="form-select">
            <option selected>Pilih...</option>
            <option value="admin">admin</option>
            <option value="user">user</option>
        </select>
        @error('role')    
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
    </div>
    {{-- <div class="col-md-5">
      <label for="jabatan" class="form-label">Jabatan</label>
      <input type="jabatan" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" value="{{ old('jabatan') }}">
      @error('jabatan')    
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
  </div>
  <div class="col-md-5">
    <label for="gender" class="form-label">Jenis Kelamin</label>
    <select id="gender" name="gender" class="form-select">
        <option selected>Pilih...</option>
        <option value="laki">admin</option>
        <option value="perempuan">laki</option>
    </select>
    @error('gender')    
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
</div>
    <div class="col-md-5">
      <label for="satker" class="form-label">satker</label>
      <input type="satker" name="satker" class="form-control @error('satker') is-invalid @enderror" id="satker" value="{{ old('satker') }}">
      @error('satker')    
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
  </div> --}}
    <div class="col-md-5">
      <label for="password" class="form-label">Password</label>
      <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password">
      @error('password')    
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
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