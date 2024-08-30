<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNotulenRequest;
use App\Http\Requests\UpdateNotulenRequest;
use App\Models\Notulen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NotulenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('laporan.notulen.notulen', [
                    "title" => "Rapat Notulen",
                    "cat" => "laporan",
                    'notulens' => Notulen::latest()->get()
                ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('laporan.notulen.data', [
            'title' => 'Form Rapat Notulen',
            'cat' => 'laporan'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNotulenRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedDoc = $request->validate([
            'judul' => 'required|max:255',
            'tanggal' => 'required|date',
            'konseptor' => 'required|max:255',
            'keterangan' => 'required|max:1000',
            'dokumen_notulen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $validatedDoc['dokumen_notulen'] = $request->file('dokumen_notulen')->store('dokumen_notulen', 'public');
        // return request()->all();
        // $file = $request->file('file');
        // $fileData = file_get_contents($file);
        // dd('data terkirim');
        Notulen::create($validatedDoc);

        return redirect('/notulen/tambah')->with('success', 'Rapat Notulen Berhasil di buat!');
    }

    public function search(Request $request)
    {
        $output="";

        $notulens=Notulen::where('judul','Like','%'.$request->search.'%')->
        orWhere('tanggal','Like','%'.$request->search.'%')->
        orWhere('konseptor','Like','%'.$request->search.'%')->
        orWhere('keterangan','Like','%'.$request->search.'%')->        
        get();

        $iteration = 1;

        foreach($notulens as $notulen)
        {
            
            $output.=
            '<tr>
                <td>'.$iteration.'</td>
                <td>'.$notulen->judul.'</td>
                <td>'.$notulen->tanggal.'</td>
                <td>'.$notulen->konseptor.'</td>
                <td><a href="/notulen/lihat/'.$notulen->id.'" target="blank" class="text-decoration-none">lihat</a></td>
                <td><a href="/notulen/'.$notulen->id.'/edit"><i class="bi bi-pencil-square"></a></td>
                    <td>
                        <button class="badge bg-danger border-0" onclick="openDeleteModal('.$notulen->id.')">
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
     * @param  \App\Models\Notulen  $notulen
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('laporan.notulen.show', [
            'title' => 'Rapat Notulen',
            'cat' => 'laporan',
            'notulen' => Notulen::find($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notulen  $notulen
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('laporan.notulen.ubah', [
            'title' => 'Update Notulen',
            "cat" => "laporan",
            'notulen' => Notulen::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNotulenRequest  $request
     * @param  \App\Models\Notulen  $notulen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $notulen = Notulen::findOrFail($id);
        $validatedDoc = $request->validate([
            'judul' => 'required|max:255',
            'tanggal' => 'required|date',
            'konseptor' => 'required|max:255',
            'keterangan' => 'required|max:1000',
            'dokumen_notulen' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        
        if ($request->file('dokumen_notulen')) {
            if($request->oldDokumen_notulen){
                Storage::delete($request->oldDokumen_notulen);
            }
            $validatedDoc['dokumen_notulen'] = $request->file('dokumen_notulen')->store('dokumen_notulen', 'public');
        }
        $notulen->where('id', $notulen->id)
            ->update($validatedDoc);

            
            return redirect('/notulen')->with('success', 'Notulen telah di update!..');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notulen  $notulen
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notulen = Notulen::find($id);
        if ($notulen->dokumen_notulen) {
            Storage::delete($notulen->dokumen_notulen);
        }
        $notulen->delete();
        // User::destroy($user->id);
        return redirect('/notulen')->with('success', 'Data Notulen Berhasil di hapus!..');
    }
}
