<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKegiatanRequest;
use App\Http\Requests\UpdateKegiatanRequest;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('laporan.kegiatan.kegiatan',[
            'title' => 'Laporan Kegiatan',
            'cat' => 'laporan',
            'laporans' => Kegiatan::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('laporan.kegiatan.data',[
            'title' => 'Input data kegiatan',
            'cat' => 'laporan'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreKegiatanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedDoc = $request->validate([
            'nama' => 'required|min:5|max:255',
            'tanggal' => 'required|date',
            'personel' => 'required|min:5|max:255',
            'kegiatan' => 'required|min:5|max:255',
            'bukti' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'buktiDua' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'buktiTiga' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $validatedDoc['bukti'] = $request->file('bukti')->store('bukti', 'public');
        // $validatedDoc['buktiDua'] = $request->file('buktiDua')->store('buktiDua', 'public');
        // $validatedDoc['buktiTiga'] = $request->file('buktiTiga')->store('buktiTiga', 'public');
        // return request()->all();
        // $file = $request->file('file');
        // $fileData = file_get_contents($file);
        // dd('data terkirim');
        Kegiatan::create($validatedDoc);

        return redirect('/kegiatan/tambah')->with('success', 'Laporan kegiatan Berhasil di buat!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\Http\Response
     */
    public function show(Kegiatan $kegiatan, $id)
    {
        return view('laporan.kegiatan.show', [
            'title' => 'bukti kegiatan',
            'cat' => 'laporan',
            'kegiatan' => Kegiatan::find($id)
        ]);
    }

    public function search(Request $request)
    {
        $output="";

        $kegiatans=Kegiatan::where('nama','Like','%'.$request->search.'%')->
        orWhere('tanggal','Like','%'.$request->search.'%')->
        orWhere('personel','Like','%'.$request->search.'%')->
        orWhere('kegiatan','Like','%'.$request->search.'%')->        
        get();

        $iteration = 1;

        foreach($kegiatans as $kegiatan)
        {
            
            $output.=
            '<tr>
                <td>'.$iteration.'</td>
                <td>'.$kegiatan->nama.'</td>
                <td>'.$kegiatan->tanggal.'</td>
                <td>'.$kegiatan->personel.'</td>
                <td>'.$kegiatan->kegiatan.'</td>
                <td><a href="/kegiatan/lihat/'.$kegiatan->id.'" target="blank" class="text-decoration-none">Lihat</a></td>
                <td><a href="/kegiatan/'.$kegiatan->id.'/edit"><i class="bi bi-pencil-square"></a></td>
                    <td>
                        <button class="badge bg-danger border-0" onclick="openDeleteModal('.$kegiatan->id.')">
                            <i class="bi bi-trash3 text-white"></i>
                        </button>
                    </td>
            </tr>';

            $iteration++;
        };
        
        return response($output);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('laporan.kegiatan.ubah', [
            'title' => 'Update Kegiatan',
            "cat" => "laporan",
            'kegiatan' => Kegiatan::find($id)
            
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKegiatanRequest  $request
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        $validatedDoc = $request->validate([
            'nama' => 'required|min:5|max:255',
            'tanggal' => 'required|date',
            'personel' => 'required|min:5|max:255',
            'kegiatan' => 'required|min:5|max:255',
            'bukti' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'buktiDua' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'buktiTiga' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        
        if ($request->file('bukti')) {
            if($request->oldBukti){
                Storage::delete($request->oldBukti);
            }
            $validatedDoc['bukti'] = $request->file('bukti')->store('bukti', 'public');
        }
        // if ($request->file('buktiDua')) {
        //     if($request->oldBuktiDua){
        //         Storage::delete($request->oldBuktiDua);
        //     }
        //     $validatedDoc['buktiDua'] = $request->file('buktiDua')->store('buktiDua', 'public');
        // }
        // if ($request->file('buktiTiga')) {
        //     if($request->oldBuktiTiga){
        //         Storage::delete($request->oldBuktiTiga);
        //     }
        //     $validatedDoc['buktiTiga'] = $request->file('buktiTiga')->store('buktiTiga', 'public');
        // }
        $kegiatan->where('id', $kegiatan->id)
            ->update($validatedDoc);

            
            return redirect('/kegiatan')->with('success', 'Kegiatan telah di update!..');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kegiatan = Kegiatan::find($id);
        if ($kegiatan->bukti) {
            Storage::delete($kegiatan->bukti);
        }
        $kegiatan->delete();
        // User::destroy($user->id);
        return redirect('/kegiatan')->with('success', 'Data kegiatan Berhasil di hapus!..');
    }
}
