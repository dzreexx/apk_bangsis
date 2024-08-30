
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dokumen | {{ $post->perihal }}</title>
    <!-- Tambahkan link ke CSS Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Tambahkan link ke pustaka Lightbox -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/css/lightbox.min.css">
    {{-- <link rel="icon" href="{{ asset('image/logotni.png') }}"> --}}
</head>
<body>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <a href="{{ asset("storage/". $post->image ) }}" data-lightbox="gambar" data-title="Deskripsi Gambar">
                    <img src="{{ asset("storage/". $post->image ) }}" class="img-fluid" alt="Foto">
                </a>
            </div>
            <!-- Informasi di sebelah kanan foto -->
            <div class="col-md-8">
                <h1>Detail Dokumen</h1>
                <ul class="list-group">
                    @if ($post->status == 'belum')
                    <li class="list-group-item bg-warning justify-content-between"><strong>Status:</strong>Belum di Proses</li>
                    @elseif($post->status == 'proses')
                    <li class="list-group-item bg-info justify-content-between"><strong>Status:</strong>Di Proses</li>
                    @elseif($post->status == 'selesai')
                    <li class="list-group-item bg-success justify-content-between"><strong>Status:</strong>Selesai</li>
                    @else
                    <li class="list-group-item bg-danger justify-content-between"><strong>Status:</strong>Di Tolak</li>

                    @endif
                    {{-- <li class="list-group-item justify-content-between"><strong>Status:</strong> {{ $post->status }}</li> --}}
                    @if ($post->status == 'tolak')
                    <li class="list-group-item justify-content-between"><strong>Keterangan:</strong> {{ $post->keterangan }}</li>
                    
                    @endif

                </ul>
                <ul class="list-group mt-2">
                    <li class="list-group-item justify-content-between"><strong>ID:</strong> {{ $post->id }}</li>
                    <li class="list-group-item justify-content-between"><strong>Perihal:</strong> {{ $post->perihal }}</li>
                    <li class="list-group-item justify-content-between"><strong>Tujuan:</strong> {{ $post->tujuan }}</li>
                    <li class="list-group-item justify-content-between"><strong>Tanggal Permintaan:</strong> {{ $post->tanggal }}</li>
                    <li class="list-group-item justify-content-between"><strong>Nama Pengirim:</strong> {{ $post->user->name }}</li>
                    <li class="list-group-item justify-content-between"><strong>Satker:</strong> {{ $post->user->satker }}</li>
                    <li class="list-group-item justify-content-between"><strong>Tanggal Input:</strong> {{ $post->created_at }}</li>
                </ul>
                @if ($post->status == 'tolak')
                <div class="mt-3">
                    <a href="/dokumen/{{ $post->id }}/edit">Ajukan Ulang</a>
                </div>
                @endif
                <div class="mt-3">
                    <a href="/permintaan">Kembali</a>
                </div>
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
