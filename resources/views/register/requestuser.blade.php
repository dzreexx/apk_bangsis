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
    <main class="col-md-9 ms-sm-1 col-lg-9 px-md-5">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Request Pengguna</h1>
        </div>
        <div class="container">
            @if (session()->has('success'))    
            <div class="alert alert-info alert-dismissible fade show" role="alert">
              <strong></strong>{{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="container mb-2 d-flex justify-content-lg-end">
            </div>
            
            {{-- <div class="container">
                <div class="search">
                    <input type="search" id="search" class="form-control mb-3" placeholder="Cari pengguna">
                </div>
            </div> --}}
            </div>
                <table>
                    <thead>
                        <tr>
                            {{-- <th>NO</th> --}}
                            <th>ID</th>
                            <th>Nama</th>
                            <th>NRP</th>
                            <th>Pangkat</th>
                            <th>Korp</th>
                            {{-- <th>Jenis Kelamin</th> --}}
                            <th>Peran</th>
                        <th>Tanggal Buat Akun</th>
                        <th>Aksi</th>
                        {{-- <th>Aksi</th> --}}
                    </tr>
                </thead>
                <tbody class="alldata">
                    @foreach ($users as $key => $user)
                    <tr>
                        {{-- <td>{{ $loop->iteration }}</td> --}}
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->nrp }}</td>
                        <td>{{ $user->pangkat }}</td>
                        <td>{{ $user->korp }}</td>
                        {{-- <td>{{ $user->gender }}</td> --}}
                        <td>{{ $user->role }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>
                            <button class="badge bg-primary border-0" onclick="openDeleteModal('{{ $user->id }}')">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tbody id="Content" class="seachData">

                </tbody>
            </table>
        </div>

        @if ($users->isEmpty())
        <div class="text-center">
            Tidak ada request pengguna
        </div>
        @endif
    </main>
<!-- Modal Konfirmasi Hapus Akun -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Verifikasi Akun</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">   
        @foreach ($users as $user)
        <form id="updateForm" method="post" action="/pengguna/request/{{ $user->id }}/edit">
        @endforeach
            @method('put')
            @csrf
            <div class="col-md-5">
                <label for="role" class="form-label">Peran</label>
                <select id="role" name="role" class="form-select">
                    <option value="user" selected>user</option>
                    <option value="admin">admin</option>
                </select>
                @error('role')    
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Verifikasi</button>
        </form>
        @foreach ($users as $user)
        <form id="deleteForm" action="/pengguna/{{ $user->id }}" method="post">
        @endforeach
            @method('delete')
            @csrf
            <button type="submit" class="btn btn-danger">Hapus Akun</button>
            </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<script>
    $('#search').on('keyup',function(){
        $value = $(this).val();
        
        if($value)
        {
            $('.alldata').hide();
            $('#Content').show();
        }
        
        else
        {
            $('.alldata').show();
            $('#Content').hide();
        }

        $.ajax({

            type:'get',
            url:'{{URL::to('/pengguna/search')}}',
            data:{'search':$value},

            success:function(data)
            {
                console.log(data);
                $('#Content').html(data);
            }
            
        });
    });
    function openDeleteModal(id) {
        // Set action attribute of the form based on user id
        var updateForm = document.getElementById('updateForm');
        updateForm.action = '/pengguna/request/' + id + '/edit';

        var deleteForm = document.getElementById('deleteForm');
        deleteForm.action = '/pengguna/' + id ;

        // Show the modal
        var modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        modal.show();
    }
</script>

</body>
</html>

@endsection
