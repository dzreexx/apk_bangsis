<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNaskahRequest;
use App\Http\Requests\UpdateNaskahRequest;
use App\Models\Naskah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NaskahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('digitalisasi-dokumen.naskah.naskah', [
            'title' => 'Digitalisasi Dokumen Naskah',
            'cat' => 'dokumen',
            'naskahs' => Naskah::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('digitalisasi-dokumen.naskah.data', [
            'title' => 'Form Input Naskah',
            'cat' => 'dokumen'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNaskahRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedDoc = $request->validate([
            'judul' => 'required|max:255',
            'tanggal' => 'required|date',
            'dokumen_naskah' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $validatedDoc['dokumen_naskah'] = $request->file('dokumen_naskah')->store('dokumen_naskah', 'public');
        Naskah::create($validatedDoc);

        return redirect('/naskah')->with('success', 'Dokumen Naskah berhasil ditambahkan!.');
    }

    public function search(Request $request)
    {
        $output="";

        $naskahs=Naskah::where('judul','Like','%'.$request->search.'%')->
        orWhere('tanggal','Like','%'.$request->search.'%')->       
        get();

        $iteration = 1;

        foreach($naskahs as $naskah)
        {
            
            $output.=
            '<tr>
                <td>'.$iteration.'</td>
                <td>'.$naskah->judul.'</td>
                <td>'.$naskah->tanggal.'</td>
                <td><a href="'.asset('storage/' . $naskah->dokumen_naskah).'" target="blank" class="text-decoration-none">Lihat</a></td>
                <td><a href="/naskah/'.$naskah->id.'/edit"><i class="bi bi-pencil-square"></a></td>
                    <td>
                        <button class="badge bg-danger border-0" onclick="openDeleteModal('.$naskah->id.')">
                            <i class="bi bi-trash3 text-white"></i>
                        </button>
                    </td>
                </tr>';

            $iteration++;
        };
        
        return response($output);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Naskah  $naskah
     * @return \Illuminate\Http\Response
     */
    public function show(Naskah $naskah)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Naskah  $naskah
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('digitalisasi-dokumen.naskah.ubah', [
            'title' => 'Update Naskah',
            "cat" => "dokumen",
            'naskah' => Naskah::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNaskahRequest  $request
     * @param  \App\Models\Naskah  $naskah
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $naskah = Naskah::findOrFail($id);
        $validatedDoc = $request->validate([
            'judul' => 'required|max:255',
            'tanggal' => 'required|date',
            'dokumen_naskah' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        
        if ($request->file('dokumen_naskah')) {
            if($request->oldDokumen_naskah){
                Storage::delete($request->oldDokumen_naskah);
            }
            $validatedDoc['dokumen_naskah'] = $request->file('dokumen_naskah')->store('dokumen_naskah', 'public');
        }
        $naskah->where('id', $naskah->id)
            ->update($validatedDoc);

            
            return redirect('/naskah')->with('success', 'Naskah telah di update!..');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Naskah  $naskah
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $naskah = Naskah::find($id);
        if ($naskah->dokumen_naskah) {
            Storage::delete($naskah->dokumen_naskah);
        }
        $naskah->delete();
        // User::destroy($user->id);
        return redirect('/naskah')->with('success', 'Data Naskah Berhasil di hapus!..');
    }
}
