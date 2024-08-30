<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMagangRequest;
use App\Http\Requests\UpdateMagangRequest;
use App\Models\Magang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MagangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('magang.magang', [
            'title' => 'Magang Mahasiswa',
            "cat" => "home",
            'magangs' => Magang::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('magang.data', [
            'title' => 'Form Magang Mahasiswa',
            "cat" => "home"
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMagangRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedDoc = $request->validate([
            'name' => 'required',
            'nim' => 'required',
            'univ' => 'required|min:5',
            'dateStart' => 'required|date',
            'dateEnd' => 'required|date',
            'judul' => 'required',
            'laporan' => 'required|mimes:pdf|max:2048'
        ]);

        $validatedDoc['laporan'] = $request->file('laporan')->store('laporan', 'public');
        Magang::create($validatedDoc);
        
        return redirect('/magang/tambah')->with('success', 'Data Magang Mahasiswa Berhasil ditambah!..');
    }

    public function search(Request $request)
    {
        $output="";

        $magangs=Magang::where('name','Like','%'.$request->search.'%')->
        orWhere('nim','Like','%'.$request->search.'%')->
        orWhere('univ','Like','%'.$request->search.'%')->
        // orWhere('lokasi','Like','%'.$request->search.'%')->
        // orWhere('kondisi','Like','%'.$request->search.'%')->
        // orWhere('satker','Like','%'.$request->search.'%')->
        
        get();

        $pala = '<thead>
        <tr>
            <th>Id</th>
            <th>Nama Mahasiswa</th>
            <th>NIM</th>
            <th>Universitas</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Selesai</th>
            <th>Judul Laporan</th>
            <th>File</th>
            <th>Edit</th>
            <th>Hapus</th>
        </tr>
        </thead>';

        foreach($magangs as $magang)
        {
            
            $output.=
            '
            <tbody>
            <tr>
                <td>'.$magang->id.'</td>
                <td>'.$magang->name.'</td>
                <td>'.$magang->nim.'</td>
                <td>'.$magang->univ.'</td>
                <td>'.$magang->dateStart.'</td>
                <td>'.$magang->dateEnd.'</td>
                <td>'.$magang->judul.'</td>
                <td><a href="'.asset('storage/' . $magang->laporan).'" target="blank">Lihat</a></td>
                <td><a href="/magang/'.$magang->id.'/edit" target="blank"><i class="bi bi-pencil-square"></a></td>
                <td>
                    <button class="badge bg-danger border-0" onclick="openDeleteModal('.$magang->id.')">
                        <i class="bi bi-trash3 text-white"></i>
                    </button>
                </td>
            </tr>
            </tbody>';
        };

        $isi = $pala . $output;
        
        return response($isi);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Magang  $magang
     * @return \Illuminate\Http\Response
     */
    public function show(Magang $magang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Magang  $magang
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('magang.ubah', [
            'title' => 'Update Magang',
            "cat" => "home",
            'magang' => Magang::find($id)
            
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMagangRequest  $request
     * @param  \App\Models\Magang  $magang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $magang = Magang::findOrFail($id);
        $validatedDoc = $request->validate([
            'name' => 'required',
            'nim' => 'required',
            'univ' => 'required|min:5',
            'dateStart' => 'required|date',
            'dateEnd' => 'required|date',
            'judul' => 'required',
            'laporan' => 'mimes:pdf|max:2048'
        ]);

        
        if ($request->file('laporan')) {
            if($request->oldLaporan){
                Storage::delete($request->oldLaporan);
            }
            $validatedDoc['laporan'] = $request->file('laporan')->store('laporan', 'public');
        }
        $magang->where('id', $magang->id)
            ->update($validatedDoc);

            
            return redirect('/magang')->with('success', 'Lapkonis telah di update!..');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Magang  $magang
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $magang = Magang::find($id);
        if ($magang->upload) {
            Storage::delete($magang->upload);
        }
        $magang->delete();
        // User::destroy($user->id);
        return redirect('/magang')->with('success', 'Data Magang Berhasil di hapus!..');
    }
}
