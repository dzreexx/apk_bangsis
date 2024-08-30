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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <main class="col-md-9 ms-sm-5 col-lg-8 px-md-1">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Digitalisasi Dokumen Paparan</h1>
        </div>
        <div class="container">
            @if (session()->has('success'))    
            <div class="alert alert-info alert-dismissible fade show" role="alert">
              <strong></strong>{{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
    <div class="table-container">
        <div class="search">
            <input type="search" id="search" class="form-control mb-3" placeholder="Cari permintaan">
        </div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Paparan</th>
                    <th>Tanggal Paparan</th>
                    <th>Dokumen Paparan</th>
                    <th>Edit</th>
                    <th>Hapus</th>
                </tr>
            </thead>
            <tbody id="allData">
                @foreach ($paparans as $key => $paparan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $paparan->judul }}</td>
                    <td>{{ $paparan->tanggal }}</td>
                    <td><a href="{{ asset('storage/' . $paparan->dokumen_paparan) }}" target="blank" class="text-decoration-none">Lihat</a></td>
                    <td><a href="/paparan/{{ $paparan->id }}/edit"><i class="bi bi-pencil-square"></a></td>
                    <td>
                        <button class="badge bg-danger border-0" onclick="openDeleteModal('{{ $paparan->id }}')">
                            <i class="bi bi-trash3 text-white"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tbody id="Cari" class="seachData">
    
            </tbody>
        </table>
    </div>
    <div class="container">
        <form action="/paparan/tambah" method="get">
            <button class="btn btn-primary" type="submit">Tambah File</button>
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
              <p>Anda yakin ingin menghapus Data Paparan?</p>
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

    <script>
        $('#search').on('keyup',function(){
        $value = $(this).val();
    
        if($value)
        {
            $('#allData').hide();
            $('#Cari').show();
        }
        
        else
        {
            $('#allData').show();
            $('#Cari').hide();
        }

        $.ajax({

            type:'get',
            url:'{{URL::to('/paparan/search')}}',
            data:{'search':$value},

            success:function(data)
            {
                console.log(data);
                $('#Cari').html(data);
            }
            
        });
    });
    function openDeleteModal(id) {
        // Set action attribute of the form based on user id
        var deleteForm = document.getElementById('deleteForm');
        deleteForm.action = '/paparan/' + id;

        // Show the modal
        var modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        modal.show();
    }
    </script>
</body>
</html>

@endsection