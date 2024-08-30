<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePeraturanRequest;
use App\Http\Requests\UpdatePeraturanRequest;
use App\Models\Peraturan;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PeraturanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('digitalisasi-dokumen.peraturan.peraturan', [
            'title' => 'Digitalisasi Dokumen Peraturan',
            'cat' => 'dokumen',
            'peraturans' => Peraturan::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('digitalisasi-dokumen.peraturan.data', [
            'title' => 'Form Dokumen Peraturan',
            'cat' => 'dokumen'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePeraturanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedDoc = $request->validate([
            'judul' => 'required|max:255',
            'tanggal' => 'required|date',
            'dokumen_peraturan' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $validatedDoc['dokumen_peraturan'] = $request->file('dokumen_peraturan')->store('dokumen_peraturan', 'public');
        Peraturan::create($validatedDoc);

        return redirect('/peraturan/tambah')->with('success', 'Digitalisasi Peraturan Berhasil ditambah!.');
    }

    public function search(Request $request)
    {
        $output="";

        $peraturans=Peraturan::where('judul','Like','%'.$request->search.'%')->
        orWhere('tanggal','Like','%'.$request->search.'%')->       
        get();

        $iteration = 1;

        foreach($peraturans as $peraturan)
        {
            
            $output.=
            '<tr>
                <td>'.$iteration.'</td>
                <td>'.$peraturan->judul.'</td>
                <td>'.$peraturan->tanggal.'</td>
                <td><a href="'.asset('storage/' . $peraturan->dokumen_peraturan).'" target="blank" class="text-decoration-none">Lihat</a></td>
                <td><a href="/peraturan/'.$peraturan->id.'/edit"><i class="bi bi-pencil-square"></a></td>
                    <td>
                        <button class="badge bg-danger border-0" onclick="openDeleteModal('.$peraturan->id.')">
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
     * @param  \App\Models\Peraturan  $peraturan
     * @return \Illuminate\Http\Response
     */
    public function show(Peraturan $peraturan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Peraturan  $peraturan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('digitalisasi-dokumen.peraturan.ubah', [
            'title' => 'Update Peraturan',
            "cat" => "dokumen",
            'peraturan' => Peraturan::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePeraturanRequest  $request
     * @param  \App\Models\Peraturan  $peraturan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $peraturan = Peraturan::findOrFail($id);
        $validatedDoc = $request->validate([
            'judul' => 'required|max:255',
            'tanggal' => 'required|date',
            'dokumen_peraturan' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        
        if ($request->file('dokumen_peraturan')) {
            if($request->oldDokumen_peraturan){
                Storage::delete($request->oldDokumen_peraturan);
            }
            $validatedDoc['dokumen_peraturan'] = $request->file('dokumen_peraturan')->store('dokumen_peraturan', 'public');
        }
        $peraturan->where('id', $peraturan->id)
            ->update($validatedDoc);

            
            return redirect('/peraturan')->with('success', 'Peraturan telah di update!..');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Peraturan  $peraturan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $peraturan = Peraturan::find($id);
        if ($peraturan->dokumen_peraturan) {
            Storage::delete($peraturan->dokumen_peraturan);
        }
        $peraturan->delete();
        // User::destroy($user->id);
        return redirect('/peraturan')->with('success', 'Data Peraturan Berhasil di hapus!..');
    }
}
