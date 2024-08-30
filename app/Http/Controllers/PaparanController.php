<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaparanRequest;
use App\Http\Requests\UpdatePaparanRequest;
use App\Models\Paparan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaparanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('digitalisasi-dokumen.paparan.paparan', [
            'title' => 'Digitalisasi Dokumen Paparan',
            'cat' => 'dokumen',
            'paparans' => Paparan::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('digitalisasi-dokumen.paparan.data', [
            'title' => 'Form Input Paparan',
            'cat' => 'dokumen'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePaparanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedDoc = $request->validate([
            'judul' => 'required|max:255',
            'tanggal' => 'required|date',
            'dokumen_paparan' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $validatedDoc['dokumen_paparan'] = $request->file('dokumen_paparan')->store('dokumen_paparan', 'public');
        Paparan::create($validatedDoc);
        
        return redirect('/paparan')->with('success', 'Dokumen Paparan Berhasil ditambahkan!.');
    }

    public function search(Request $request)
    {
        $output="";

        $paparans=Paparan::where('judul','Like','%'.$request->search.'%')->
        orWhere('tanggal','Like','%'.$request->search.'%')->       
        get();

        $iteration = 1;

        foreach($paparans as $paparan)
        {
            
            $output.=
            '<tr>
                <td>'.$iteration.'</td>
                <td>'.$paparan->judul.'</td>
                <td>'.$paparan->tanggal.'</td>
                <td><a href="'.asset('storage/' . $paparan->dokumen_paparan).'" target="blank" class="text-decoration-none">Lihat</a></td>
                <td><a href="/paparan/'.$paparan->id.'/edit"><i class="bi bi-pencil-square"></a></td>
                    <td>
                        <button class="badge bg-danger border-0" onclick="openDeleteModal('.$paparan->id.')">
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
     * @param  \App\Models\Paparan  $paparan
     * @return \Illuminate\Http\Response
     */
    public function show(Paparan $paparan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Paparan  $paparan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('digitalisasi-dokumen.paparan.ubah', [
            'title' => 'Update Paparan',
            "cat" => "dokumen",
            'paparan' => Paparan::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePaparanRequest  $request
     * @param  \App\Models\Paparan  $paparan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $paparan = Paparan::findOrFail($id);
        $validatedDoc = $request->validate([
            'judul' => 'required|max:255',
            'tanggal' => 'required|date',
            'dokumen_paparan' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        
        if ($request->file('dokumen_paparan')) {
            if($request->oldDokumen_paparan){
                Storage::delete($request->oldDokumen_paparan);
            }
            $validatedDoc['dokumen_paparan'] = $request->file('dokumen_paparan')->store('dokumen_paparan', 'public');
        }
        $paparan->where('id', $paparan->id)
            ->update($validatedDoc);

            
            return redirect('/paparan')->with('success', 'paparan telah di update!..');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Paparan  $paparan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $paparan = Paparan::find($id);
        if ($paparan->dokumen_paparan) {
            Storage::delete($paparan->dokumen_paparan);
        }
        $paparan->delete();
        // User::destroy($user->id);
        return redirect('/paparan')->with('success', 'Data Paparan Berhasil di hapus!..');
    }
}
