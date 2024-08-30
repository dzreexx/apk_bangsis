@extends('layouts.main')

@section('container')
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha384-Z2ISwQkTFYpMDtvi4LH6fndFIIpIfFgsrHcMNIta7vaW8+um1RBPGbhC2MZ1BwPR" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <title>Permintaan Aplikasi</title> --}}
    <style>
        .container {
            text-align: center;
            margin-top: 20px;
        }

        .table-container {
            max-height: 400px; /* Atur ketinggian maksimum yang diinginkan */
            overflow-y: auto; /* Atur agar terjadi overflow dengan scrolldown jika lebih dari ketinggian maksimum */
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .sub-table {
            display: none;
            background-color: #f9f9f9;
            margin-top: 10px;
        }

        .sub-table th, .sub-table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        .dropdown-btn {
            cursor: pointer;
            text-decoration: underline;
            color: blue;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    @if (session()->has('error'))    
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if (session()->has('success'))    
    <div class="alert alert-info alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if (auth()->user()->role == 'user')
    <div class="container bg-accent-color-1 text-white">
        <h4>Permintaan Aplikasi</h4>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Perihal</th>
                    <th>Tanggal Permintaan</th>
                    <th>Satker</th>
                    <th>Tanggal Input</th>
                    <th>Status</th>
                    <th>Lihat Dokumen</th>
                    <th>Hapus</th>
                    {{-- <th>Aksi</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $key => $post)
                <tr>
                    {{-- <td>{{ $post->id }}</td> --}}
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $post->perihal }}</td>
                    <td>{{ $post->tanggal }}</td>
                    <td>{{ $post->user->satker }}</td>
                    <td>{{ $post->created_at }}</td>
                    @if ($post->status == 'proses')

                    <td class="text-bg-info">Proses</td>
                    @elseif ($post->status == 'belum')
                        
                    <td class="text-bg-warning">Belum Proses</td>
                    
                    @elseif ($post->status == 'tolak')
                        
                    <td class="text-bg-danger">di tolak</td>
                    
                    @else
                    <td class="text-bg-success">Selesai</td>
                        
                    @endif
                    <td><a href="/dokumen/{{ $post->id }}" target="_blank">Lihat</a></td>
                    <td>
                        <button class="badge bg-danger border-0" onclick="openDeleteModal('{{ $post->id }}')">
                            <i class="bi bi-trash3 text-white"></i>
                        </button>
                    </td>
                    {{-- <td class="dropdown-btn text-decoration-none" onclick="toggleSubTable('subTable{{ $post->id }}', this)">Lihat</td> --}}
                </tr>
                <tr id="subTable{{ $post->id }}" class="sub-table">
                    <td colspan="8">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Judul</th>
                                    <th>Tujuan</th>
                                    <th>File</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $post->id }}</td>
                                    <td>{{ $post->judul }}</td>
                                    <td>{{ $post->tujuan }}</td>
                                    <td>{{ $post->image }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="container">
        <form action="/data" method="get">
            <button class="btn btn-primary" type="submit">Tambah Permintaan</button>
        </form>
    </div>
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus Data</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>Anda yakin ingin menghapus Permintaan Aplikasi?</p>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <form id="deleteForm" method="post" action="">
                @method('delete')
                @csrf
                <button type="submit" class="btn btn-danger">Hapus</button>
            </form>
            </div>
        </div>
        </div>
    </div>

    @endif
    
    <script>
        function openDeleteModal(id) {
        // Set action attribute of the form based on user id
        var deleteForm = document.getElementById('deleteForm');
        deleteForm.action = '/permintaan/' + id;

        // Show the modal
        var modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        modal.show();
    }
        function toggleSubTable(subTableId, btn) {
            const subTable = document.getElementById(subTableId);
            const parentRow = btn.parentNode; // Baris yang mengandung tombol
    
            // Sembunyikan semua subtabel
            const allSubTables = document.querySelectorAll('.sub-table');
            allSubTables.forEach(table => {
                table.style.display = 'none';
            });
    
            // Hapus warna latar belakang dari baris sebelumnya
            const allRows = document.querySelectorAll('tbody tr');
            allRows.forEach(row => {
                row.style.backgroundColor = '';
            });
    
            // Jika subtabel sudah terlihat, sembunyikan
            if (subTable.style.display !== 'none') {
                subTable.style.display = 'none';
            } else {
                // Jika subtabel belum terlihat, tampilkan di bawah baris yang dipilih
                subTable.style.display = 'table-row';
    
                // Atur warna latar belakang pada baris yang dipilih
                parentRow.style.backgroundColor = '#e6f7ff';
            }
        }


        
    </script>
</body>
</html>
@endsection
