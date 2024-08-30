@extends('layouts.main')

@section('container')
<form class="row g-3 mb-5" action="data" method="post" >
    @csrf
    <h4 class="text-center mt-5">Form Data Help Desk</h4>
    <div class="col-md-6">
        <label for="no" class="form-label">Nomor Dokumen</label>
        <input type="number" name="no" class="form-control" id="no">
    </div>
    <div class="col-md-6">
        <label for="tanggal" class="form-label">Tanggal</label>
        <input type="date" name="tanggal" class="form-control" id="tangal">
    </div>
    <div class="col-md-6">
        <label for="judul" class="form-label">Judul</label>
        <input type="text" name="judul" class="form-control" id="judul">
    </div>
    <div class="col-md-6">
        <label for="asal" class="form-label">Asal</label>
        <select id="asal" name="asal" class="form-select">
            <option selected>Pilih...</option>
            <option>Aceh</option>
            <option>Sumatera Utara</option>
            <option>Sumatera Barat</option>
            <option>Riau</option>
            <option>Kepulauan Riau</option>
            <option>Jambi</option>
            <option>Sumatera Selatan</option>
            <option>Bengkulu</option>
            <option>Lampung</option>
            <option>Kepulauan Bangka Belitung</option>
            <option>DKI Jakarta</option>
            <option>Jawa Barat</option>
            <option>Banten</option>
            <option>Jawa Tengah</option>
            <option>DI Yogyakarta</option>
            <option>Jawa Timur</option>
            <option>Bali</option>
            <option>Nusa Tenggara Barat</option>
            <option>Nusa Tenggara Timur</option>
            <option>Kalimantan Barat</option>
            <option>Kalimantan Tengah</option>
            <option>Kalimantan Selatan</option>
            <option>Kalimantan Timur</option>
            <option>Kalimantan Utara</option>
            <option>Sulawesi Utara</option>
            <option>Sulawesi Tengah</option>
            <option>Sulawesi Selatan</option>
            <option>Sulawesi Tenggara</option>
            <option>Gorontalo</option>
            <option>Maluku</option>
            <option>Maluku Utara</option>
            <option>Papua Barat</option>
            <option>Papua</option>
            </select>            
    </div>
    <div class="col-6">
        <label for="tujuan" class="form-label">Tujuan</label>
        <input type="text" name="tujuan" class="form-control" id="tujuan">
    </div>
    <div class="col-6">
        <label for="file" class="form-label">Link File</label>
        <input type="url" name="file" class="form-control" id="file">
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn-primary">Sign in</button>
    </div>
    </form>
@endsection