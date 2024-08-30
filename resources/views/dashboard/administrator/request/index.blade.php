@extends('dashboard.index')

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
    <main class="col-md-9 ms-sm-1 col-lg-9 px-md-1">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Request Permintaan</h1>
        </div>
        <div class="container">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Penginput</th>
                        <th>Perihal</th>
                        <th>Tanggal Permintaan</th>
                        <th>Satker</th>
                        <th>Tanggal Input</th>
                        <th>Status</th>
                        <th>CRUD</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $key => $post)
                        @if ($post->status == 'belum')    
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $post->user->name }}</td>
                                <td>{{ $post->perihal }}</td>
                                <td>{{ $post->tanggal }}</td>
                                <td>{{ $post->user->satker }}</td>
                                <td>{{ $post->created_at }}</td>
                                <td class="bg-warning">{{ $post->status }} proses</td>
                                <td>
                                    <a href="/permintaan/{{ $post->id }}"><i class="bi bi-eye"></i></a>
                                    <a href="#"><i class="bi bi-pencil"></i></a>
                                    <button class="border-0 badge bg-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-id="{{ $post->id }}">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="container">
            Data di atas adalah beberapa file yang ada
        </div>
    </main>

    <!-- Modal Konfirmasi Hapus Permintaan -->
    <div class="modal" tabindex="-1" id="confirmDeleteModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus Permintaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Anda yakin ingin menghapus permintaan ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST" class="d-inline">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-qGi5D1CfBhRvF3L3nDO3XEnF71QBu5hR1cjsh05XSyl9Za2eQH4tEuWyn2rECupY" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var deleteButtons = document.querySelectorAll('.bg-danger');
            var deleteForm = document.getElementById('deleteForm');

            deleteButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    var postId = button.getAttribute('data-id');
                    var formAction = '/request/' + postId;

                    deleteForm.setAttribute('action', formAction);
                });
            });
        });
    </script>
</body>
</html>

@endsection
