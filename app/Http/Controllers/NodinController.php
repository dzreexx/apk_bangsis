<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNodinRequest;
use App\Http\Requests\UpdateNodinRequest;
use App\Models\Nodin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NodinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('laporan.nodin.nodin', [
                    "title" => "Rapat Nodin",
                    "cat" => "laporan",
                    "nodins" => Nodin::latest()->get()
                ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('laporan.nodin.data', [
            'title' => 'Form Rapat Nodin',
            'cat' => 'laporan'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNodinRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedDoc = $request->validate([
            'no' => 'required|max:255',
            'judul' => 'required|max:255',
            'tanggal' => 'required|date',
            'konseptor' => 'required|max:255',
            'keterangan' => 'required|max:1000',
            'dokumen_nodin' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $validatedDoc['dokumen_nodin'] = $request->file('dokumen_nodin')->store('dokumen_nodin', 'public');
        // return request()->all();
        // $file = $request->file('file');
        // $fileData = file_get_contents($file);
        // dd('data terkirim');
        Nodin::create($validatedDoc);

        return redirect('/nodin/tambah')->with('success', 'Rapat Nodin Berhasil di buat!');
    }

    public function search(Request $request)
    {
        $output="";

        $nodins=Nodin::where('judul','Like','%'.$request->search.'%')->
        orWhere('tanggal','Like','%'.$request->search.'%')->
        orWhere('konseptor','Like','%'.$request->search.'%')->
        orWhere('keterangan','Like','%'.$request->search.'%')->        
        orWhere('no','Like','%'.$request->search.'%')->        
        get();

        $iteration = 1;

        foreach($nodins as $nodin)
        {
            
            $output.=
            '<tr>
                <td>'.$nodin->no.'</td>
                <td>'.$nodin->judul.'</td>
                <td>'.$nodin->tanggal.'</td>
                <td>'.$nodin->konseptor.'</td>
                <td><a href="/nodin/lihat/'.$nodin->id.'" target="blank" class="text-decoration-none">lihat</a></td>
                <td><a href="/nodin/'.$nodin->id.'/edit"><i class="bi bi-pencil-square"></a></td>
                    <td>
                        <button class="badge bg-danger border-0" onclick="openDeleteModal('.$nodin->id.')">
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
     * @param  \App\Models\Nodin  $nodin
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('laporan.nodin.show', [
            'title' => 'Dokumen Rapat Nodin',
            'cat' => 'laporan',
            'nodin' => Nodin::find($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Nodin  $nodin
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('laporan.nodin.ubah', [
            'title' => 'Update Nodin',
            "cat" => "laporan",
            'nodin' => Nodin::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNodinRequest  $request
     * @param  \App\Models\Nodin  $nodin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $nodin = Nodin::findOrFail($id);
        $validatedDoc = $request->validate([
            'no' => 'required|max:255',
            'judul' => 'required|max:255',
            'tanggal' => 'required|date',
            'konseptor' => 'required|max:255',
            'keterangan' => 'required|max:1000',
            'dokumen_nodin' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        
        if ($request->file('dokumen_nodin')) {
            if($request->oldDokumen_nodin){
                Storage::delete($request->oldDokumen_nodin);
            }
            $validatedDoc['dokumen_nodin'] = $request->file('dokumen_nodin')->store('dokumen_nodin', 'public');
        }
        $nodin->where('id', $nodin->id)
            ->update($validatedDoc);

            
            return redirect('/nodin')->with('success', 'Nodin telah di update!..');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Nodin  $nodin
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $nodin = Nodin::find($id);
        if ($nodin->dokumen_nodin) {
            Storage::delete($nodin->dokumen_nodin);
        }
        $nodin->delete();
        // User::destroy($user->id);
        return redirect('/nodin')->with('success', 'Data Nodin Berhasil di hapus!..');
    }
}
