<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResumeRequest;
use App\Http\Requests\UpdateResumeRequest;
use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResumeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('laporan.resume.resume',[
            'title' => 'Rapat Resume',
            'cat' => 'laporan',
            'resumes' => Resume::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('laporan.resume.data', [
            'title' => 'Form Rapat Resume',
            'cat' => 'laporan'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreResumeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedDoc = $request->validate([
            'judul' => 'required|max:255',
            'tanggal' => 'required|date',
            'konseptor' => 'required|max:255',
            'keterangan' => 'required|max:1000',
            'dokumen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $validatedDoc['dokumen'] = $request->file('dokumen')->store('dokumen', 'public');
        // return request()->all();
        // $file = $request->file('file');
        // $fileData = file_get_contents($file);
        // dd('data terkirim');
        Resume::create($validatedDoc);

        return redirect('/resume/tambah')->with('success', 'Rapat Resume Berhasil di buat!');
    }

    public function search(Request $request)
    {
        $output="";

        $resumes=Resume::where('judul','Like','%'.$request->search.'%')->
        orWhere('tanggal','Like','%'.$request->search.'%')->
        orWhere('konseptor','Like','%'.$request->search.'%')->
        orWhere('keterangan','Like','%'.$request->search.'%')->        
        get();

        $iteration = 1;

        foreach($resumes as $resume)
        {
            
            $output.=
            '<tr>
                <td>'.$iteration.'</td>
                <td>'.$resume->judul.'</td>
                <td>'.$resume->tanggal.'</td>
                <td>'.$resume->konseptor.'</td>
                <td><a href="/resume/lihat/'.$resume->id.'" target="blank" class="text-decoration-none">lihat</a></td>
                <td><a href="/resume/'.$resume->id.'/edit"><i class="bi bi-pencil-square"></a></td>
                    <td>
                        <button class="badge bg-danger border-0" onclick="openDeleteModal('.$resume->id.')">
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
     * @param  \App\Models\Resume  $resume
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('laporan.resume.show', [
            'title' => 'Rapat Resume',
            'cat' => 'laporan',
            'resume' => Resume::find($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Resume  $resume
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('laporan.resume.ubah', [
            'title' => 'Update Resume',
            "cat" => "laporan",
            'resume' => Resume::find($id)
            
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateResumeRequest  $request
     * @param  \App\Models\Resume  $resume
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $resume = Resume::findOrFail($id);
        $validatedDoc = $request->validate([
            'judul' => 'required|max:255',
            'tanggal' => 'required|date',
            'konseptor' => 'required|max:255',
            'keterangan' => 'required|max:1000',
            'dokumen' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        
        if ($request->file('dokumen')) {
            if($request->oldDokumen){
                Storage::delete($request->oldDokumen);
            }
            $validatedDoc['dokumen'] = $request->file('dokumen')->store('dokumen', 'public');
        }
        $resume->where('id', $resume->id)
            ->update($validatedDoc);

            
            return redirect('/resume')->with('success', 'Resume telah di update!..');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Resume  $resume
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $resume = Resume::find($id);
        if ($resume->dokumen) {
            Storage::delete($resume->dokumen);
        }
        $resume->delete();
        // User::destroy($user->id);
        return redirect('/resume')->with('success', 'Data Resume Berhasil di hapus!..');
    }
}
