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
          <h1 class="h2">Permintaan Aplikasi</h1>
        </div>
        <div class="container">
            @if (session()->has('success'))    
            <div class="alert alert-info alert-dismissible fade show" role="alert">
              <strong></strong>{{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="search">
                <input type="search" id="search" class="form-control mb-3" placeholder="Cari permintaan">
            </div>
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
                    {{-- <th>Aksi</th> --}}
                    </tr>
                </thead>
                <tbody id="allData">
                    @foreach ($doks as $key => $dok)
                <tr>
                    {{-- <td>{{ $post->id }}</td> --}}
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $dok->perihal }}</td>
                    <td>{{ $dok->tanggal }}</td>
                    <td>{{ $dok->user->satker }}</td>
                    <td>{{ $dok->created_at }}</td>
                    @if ($dok->status == 'proses')

                    <td class="text-bg-info">Proses</td>

                    @elseif($dok->status == 'selesai')
                    <td class="text-bg-success">Selesai</td>

                    @else
                    <td class="text-bg-warning">Belum Proses</td>
                        
                    @endif
                    <td><a href="/dokumen/{{ $dok->id }}" target="_blank">Lihat</a></td>
                    {{-- <td class="dropdown-btn text-decoration-none" onclick="toggleSubTable('subTable{{ $post->id }}', this)">Lihat</td> --}}
                </tr>
                <tr id="subTable{{ $dok->id }}" class="sub-table">
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
                                    <td>{{ $dok->id }}</td>
                                    <td>{{ $dok->judul }}</td>
                                    <td>{{ $dok->tujuan }}</td>
                                    <td>{{ $dok->image }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                @endforeach
                </tbody>
                <tbody id="Cari" class="seachData">
            
                </tbody>
            </table>
        </div>
        <div class="container">
            data diatas adalah beberapa file yang ada
        </div>
    </main>
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

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
            url:'{{URL::to('/posts/search')}}',
            data:{'search':$value},

            success:function(data)
            {
                console.log(data);
                $('#Cari').html(data);
            }
            
        });
    });
        // function toggleSubTable(subTableId, btn) {
        //     const subTable = document.getElementById(subTableId);
        //     const parentRow = btn.parentNode; // Baris yang mengandung tombol
    
        //     // Sembunyikan semua subtabel
        //     const allSubTables = document.querySelectorAll('.sub-table');
        //     allSubTables.forEach(table => {
        //         table.style.display = 'none';
        //     });
    
        //     // Hapus warna latar belakang dari baris sebelumnya
        //     const allRows = document.querySelectorAll('tbody tr');
        //     allRows.forEach(row => {
        //         row.style.backgroundColor = '';
        //     });
    
        //     // Jika subtabel sudah terlihat, sembunyikan
        //     if (subTable.style.display !== 'none') {
        //         subTable.style.display = 'none';
        //     } else {
        //         // Jika subtabel belum terlihat, tampilkan di bawah baris yang dipilih
        //         subTable.style.display = 'table-row';
    
        //         // Atur warna latar belakang pada baris yang dipilih
        //         parentRow.style.backgroundColor = '#e6f7ff';
        //     }
        // }


        
    </script>

</body>
</html>

@endsection






