
@extends('layouts.main')

@section('container')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Registrasi</title>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
          {{-- <div class="d-flex justify-content-center">
            <img class="mb-4" src="../image/logotni.png" alt="" width="100" height="100">
        </div> --}}
            <div class="">
                <div class="card-header text-center">
                    <h4>Registrasi</h4>
                </div>
                <div class="card-body">
                    <form aaction="/pengguna/tambah" method="POST">
                      @csrf
                        <div class="form-group">
                            <label for="name">Nama:</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required autofocus placeholder="" value="{{ old('name') }}">
                            @error('name')    
                              <div class="invalid-feedback">
                                  {{ $message }}
                              </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nrp">NRP:</label>
                            <input type="number" class="form-control @error('nrp') is-invalid @enderror" id="nrp" name="nrp" required placeholder="" value="{{ old('nrp') }}">
                            @error('nrp')    
                              <div class="invalid-feedback">
                                  {{ $message }}
                              </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="pangkat">Pangkat:</label>
                            <input type="text" class="form-control @error('pangkat') is-invalid @enderror" id="pangkat" name="pangkat" required placeholder="" value="{{ old('pangkat') }}">
                            @error('pangkat')    
                              <div class="invalid-feedback">
                                  {{ $message }}
                              </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="korp">Korp:</label>
                            <input type="text" class="form-control @error('korp') is-invalid @enderror" id="korp" name="korp" required placeholder="" value="{{ old('korp') }}">
                            @error('korp')    
                              <div class="invalid-feedback">
                                  {{ $message }}
                              </div>
                            @enderror
                        </div>
                        
                        @auth
                            @if (auth()->check() && auth()->user()->role === 'admin')
                            <div class="col-md-12">
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
                            @endif
                        @endauth
                      @guest
                      <div class="form-group">
                          <label for="jabatan">Jabatan:</label>
                          <input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan" required placeholder="" value="{{ old('jabatan') }}">
                          @error('jabatan')    
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                          @enderror
                      </div>
                      <div class="form-group">
                          <label for="gender">Jenis Kelamin:</label>
                          <select class="form-control" id="gender" name="gender" required>
                              <option value="laki">Laki-laki</option>
                              <option value="perempuan">Perempuan</option>
                          </select>
                      </div>
                      <div class="form-group">
                          <label for="satker">Satker:</label>
                          <input type="text" class="form-control @error('satker') is-invalid @enderror" id="satker" name="satker" required placeholder="" value="{{ old('satker') }}">
                          @error('satker')    
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                          @enderror
                      </div>
                      @endguest
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                            @error('password')    
                              <div class="invalid-feedback">
                                  {{ $message }}
                              </div>
                            @enderror
                        </div>
                        <div class="text-center">
                          <button type="submit" class="btn btn-primary mt-5">Daftar</button>
                        </div>
                    </form>
                  </div>
                </div>
                @guest
                <small class="text-center mt-5 mb-5 d-block">Sudah punya Akun? <a href="login">Login</a></small>
                @endguest
              </div>
    </div>
</div>
</body>
</html>
@endsection