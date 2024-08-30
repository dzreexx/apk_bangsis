<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLapkonisRequest;
use App\Http\Requests\UpdateLapkonisRequest;
use App\Models\Lapkonis;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



class LapkonisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('lapkonis.sisfo', [
            'title' => 'Lapkonis Sisfo',
            "cat" => "home",
            'sisfos' => Lapkonis::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('lapkonis.data', [
            'title' => 'Form Lapkonis Sisfo',
            "cat" => "home"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLapkonisRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedDoc = $request->validate([
            'name' => 'required',
            'tanggal' => 'required',
            'klasifikasi' => 'required',
            'lokasi' => 'required',
            'kondisi' => [
                'required', 
                Rule::in(['mati', 'hidup', 'tidak']),
        ],
            'alamat' => 'required',
            'satker' => 'required',
            'upload' => 'required'
        ]);
        // dd($validatedDoc);
        $validatedDoc['upload'] = $request->file('upload')->store('upload', 'public');
        Lapkonis::create($validatedDoc);
        return redirect('/lapkonis/tambah')->with('success', 'File Lapkonis Sisfo Berhasil ditambahkan');
    }

    public function search(Request $request)
    {
        $output="";

        $sisfos=Lapkonis::where('name','Like','%'.$request->search.'%')->
        orWhere('name','Like','%'.$request->search.'%')->
        orWhere('tanggal','Like','%'.$request->search.'%')->
        orWhere('lokasi','Like','%'.$request->search.'%')->
        orWhere('kondisi','Like','%'.$request->search.'%')->
        orWhere('satker','Like','%'.$request->search.'%')->
        
        get();

        $pala = '<thead>
        <tr>
            <th>No</th>
            <th>Nama Aplikasi</th>
            <th>Tahun Pembuatan</th>
            <th>Lokasi</th>
            <th>Kondisi</th>
            <th>Satker Pengguna</th>
            <th>Dokumen</th>
            <th>Ubah</th>
            <th>Hapus</th>
        </tr>
        </thead>';

        $iteration = 1;
        foreach($sisfos as $sisfo)
        {
            if ($sisfo->kondisi == 'mati') {
                $isi = 'Mati';
            }elseif ($sisfo->kondisi == 'hidup'){
                $isi = 'Hidup';
            }else {
                $isi = 'Tidak digunakan';
            }
            $output.=
            '
            <tbody>
            <tr>
            <td>'.$iteration.'</td>
            <td>'.$sisfo->name.'</td>
            <td>'.$sisfo->tanggal.'</td>
            <td>'.$sisfo->lokasi.'</td>
            <td>'.$isi.'</td>
            <td>'.$sisfo->satker.'</td>
            <td><a href="/lapkonis/lihat/'.$sisfo->id.'" target="blank">Lihat</a></td>
            <td><a href="/lapkonis/'.$sisfo->id.'/edit"><i class="bi bi-pencil-square"></i></a></td>
                    <td>
                        <button class="badge bg-danger border-0" onclick="openDeleteModal('.$sisfo->id.')">
                            <i class="bi bi-trash3 text-white"></i>
                        </button>
                    </td>
            <tr>
            </tbody>';

            $iteration++;
        };

        $isi = $pala . $output;
        
        return response($isi);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lapkonis  $lapkonis
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('dok-sisfo', [
            'title' => 'Dokumen Lapkonis',
            'sisfo' => Lapkonis::find($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lapkonis  $lapkonis
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('lapkonis.ubah', [
            'title' => 'Update Lapkonis',
            "cat" => "home",
            'sisfo' => Lapkonis::find($id)
            
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLapkonisRequest  $request
     * @param  \App\Models\Lapkonis  $lapkonis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sisfo = Lapkonis::findOrFail($id);
        $validatedDoc = $request->validate([
            'name' => '',
            'tanggal' => '',
            'klasifikasi' => '',
            'lokasi' => '',
            'kondisi' => [
                Rule::in(['mati', 'hidup', 'tidak']),
        ],
            'alamat' => '',
            'satker' => '',
            'upload' => ''
        ]);

        
        if ($request->file('upload')) {
            if($request->oldUpload){
                Storage::delete($request->oldUpload);
            }
            $validatedDoc['upload'] = $request->file('upload')->store('upload', 'public');
        }
        $sisfo->where('id', $sisfo->id)
            ->update($validatedDoc);

            
            return redirect('/lapkonis')->with('success', 'Lapkonis telah di update!..');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lapkonis  $lapkonis
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lapkonis $lapkonis, $id)
    {
        $sisfo = Lapkonis::find($id);
        if ($sisfo->upload) {
            Storage::delete($sisfo->upload);
        }
        $sisfo->delete();
        // User::destroy($user->id);
        return redirect('/lapkonis')->with('success', 'Data Lapkonis Sisfo Berhasil di hapus!..');
    }
}
