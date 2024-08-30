<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dokumen | {{ $resume->judul }}</title>
    <!-- Tambahkan link ke CSS Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Tambahkan link ke pustaka Lightbox -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/css/lightbox.min.css">
    <link rel="icon" href="{{ asset('image/logotni.png') }}">
</head>
<body>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <a href="{{ asset("storage/". $resume->dokumen ) }}" data-lightbox="gambar" data-title="Deskripsi Gambar">
                    <img src="{{ asset("storage/". $resume->dokumen ) }}" class="img-fluid" alt="Foto">
                </a>
            </div>
            <!-- Informasi di sebelah kanan foto -->
            <div class="col-md-8">
                <h1 class="text-capitalize">{{ $resume->nama }}</h1>
                <ul class="list-group">
                    <li class="list-group-item justify-content-between"><strong>ID:</strong> {{ $resume->id }}</li>
                    <li class="list-group-item justify-content-between"><strong>Judul:</strong> {{ $resume->judul }}</li>
                    <li class="list-group-item justify-content-between"><strong>Tanggal Resume:</strong> {{ $resume->tanggal }}</li>
                    <li class="list-group-item justify-content-between"><strong>Konseptor:</strong> {{ $resume->konseptor }}</li>
                    <li class="list-group-item justify-content-between"><strong>Keterangan:</strong> {{ $resume->keterangan }}</li>
                </ul>
            </div>
        </div>
    </div>
    
<!-- Tambahkan link ke JS Bootstrap, Popper.js, dan Lightbox -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/js/lightbox.min.js"></script>

</body>
</html>
