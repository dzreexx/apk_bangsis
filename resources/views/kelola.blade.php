@extends('dashboard.menu')

@section('content')
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
</head>
<body>
    <main class="col-md-9 ms-sm-5 col-lg-8 px-md-1">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Kelola Permintaan Aplikasi</h1>
        </div>
        <div class="container">
            @if (session()->has('success'))    
            <div class="alert alert-info alert-dismissible fade show" role="alert">
              <strong></strong>{{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
        
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
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($doks as $key => $dok)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $dok->perihal }}</td>
                            <td>{{ $dok->tanggal }}</td>
                            <td>{{ $dok->user->satker }}</td>
                            <td>{{ $dok->created_at }}</td>
                            @if ($dok->status == 'proses')
                                <td class="text-bg-info">Proses</td>
                            @else
                                <td class="text-bg-warning">Belum Proses</td>
                            @endif
                            <td><a href="/dokumen/{{ $dok->id }}" target="_blank">Lihat</a></td>
                            <td>
                                <button class="badge bg-primary border-0" onclick="openDeleteModal('{{ $dok->id }}')">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if ($doks->isEmpty())
        <div class="container">
            Tidak ada Permintaan Aplikasi
        </div>
        @endif

    </main>

    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Permintaan Aplikasi</h5>
                    @foreach ($doks as $dok)
                    <form id="updateForm" method="post" action="/kelola/{{ $dok->id }}/edit">
                    @endforeach
                        @method('put')
                        @csrf
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-select" value="{{ old('status') }}">
                            <option selected>Pilih...</option>
                            <option value="proses">Proses</option>
                            <option value="belum">Belum Proses</option>
                            <option value="selesai">Selesai</option>
                            <option value="tolak">Tolak</option>
                        </select>
                    </div>
                    <!-- Tampilkan formulir input keterangan hanya jika status yang dipilih adalah "tolak" -->
                    <div id="keteranganInput" style="display:none;">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <input type="text" id="keterangan" name="keterangan" class="form-control" value="{{ old('keterangan') }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                @foreach ($doks as $dok)
                <form id="deleteForm" action="/kelola/{{ $dok->id }}" method="POST">
                @endforeach
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <script>
        
        document.getElementById('status').addEventListener('change', function() {
            var keteranganInput = document.getElementById('keteranganInput');
            if (this.value === 'tolak') {
                keteranganInput.style.display = 'block';
            } else {
                keteranganInput.style.display = 'none';
            }
        });

        function openDeleteModal(id) {
            // Set action attribute of the form based on user id
            var updateForm = document.getElementById('updateForm');
            updateForm.action = '/kelola/' + id + '/edit';
            
            var deleteForm = document.getElementById('deleteForm');
            deleteForm.action = '/kelola/' + id ;

            // Show the modal
            var modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            modal.show();
        }
    </script>

</body>
</html>

@endsection