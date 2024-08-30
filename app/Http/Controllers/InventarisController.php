<?php

namespace App\Http\Controllers;

use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Inventaris;

class InventarisController extends Controller
{
    public function index()
    {
        return view('inventaris',[
            'title' => 'Inventaris Bangsis',
            "cat" => "home",
            'invens' => Inventaris::latest()->get()
        ]);
    }

    public function data()
    {
        return view('dashboard.inventaris.index',[
            'title' => 'Inventaris Bangsis Input',
            "cat" => "home"
        ]);
    }

    public function store(Request $request)
    {
        $validatedDoc = $request->validate([
            'barang' => 'required|string',
            'serial' => 'required|string',
            'jenisBarang' => 'required|string',
            // 'jenis' => [
            //     'required',
            //     Rule::in(['pc','monitor','tv','printer','lain']),
            // ],
            'customJenis' => 'required_if:jenis,lain',
            'merk' => 'required|string',
            'tanggal' => 'required|date',
            'kondisi' => [
                'required',
                Rule::in(['baik','rusak ringan','rusak berat']),
            ],
        ]);
        // dd($validatedDoc);
        Inventaris::create($validatedDoc);
        return redirect('/inventaris-input')->with('success', 'Pengajuan berhasil dibuat.');
    }

    public function search(Request $request)
    {
        $output="";

        $invens=Inventaris::where('barang','Like','%'.$request->search.'%')->
        orWhere('serial','Like','%'.$request->search.'%')->
        orWhere('id','Like','%'.$request->search.'%')->
        orWhere('jenisBarang','Like','%'.$request->search.'%')->
        orWhere('customJenis','Like','%'.$request->search.'%')->
        orWhere('merk','Like','%'.$request->search.'%')->
        orWhere('tanggal','Like','%'.$request->search.'%')->
        orWhere('kondisi','Like','%'.$request->search.'%')->
        get();

        $pala = '<thead>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Serial Number</th>
            <th>Jenis Barang</th>
            <th>Merk</th>
            <th>Tanggal Pembuatan</th>
            <th>Kondisi</th>
            <th>Edit</th>
            <th>Hapus</th>
        </tr>
        </thead>';

        $iteration = 1;
        foreach($invens as $inven)
        {
            if ($inven->jenisBarang === 'lain') {
                $jb = $inven->customJenis;
            } else {
                $jb = $inven->jenisBarang;
            }
            if ($inven->kondisi == 'baik') {
                $bg='text-bg-success';
                $txt='Baik';
            } elseif ($inven->kondisi == 'rusak ringan') {
                $bg='text-bg-warning';
                $txt='Rusak Ringan';
            } else {
                $bg='text-bg-danger';
                $txt='Rusak Berat';
            }


            $output.=
            '<tbody>
            <tr>
                <td> '.$iteration.' </td>
                <td> '.$inven->barang.' </td>
                <td> '.$inven->serial.' </td>
                <td> '.$jb.' </td>
                <td> '.$inven->merk.' </td>
                <td> '.$inven->tanggal.' </td>
                <td class='.$bg.'> '.$txt.' </td>
                <td>
                        <a href="/inventaris/'.$inven->id.'/edit">lihat</a>
                    </td>
                <td>
                    <button class="badge bg-danger border-0" onclick="openDeleteModal('.$inven->id.')">
                        <i class="bi bi-trash3 text-white"></i>
                    </button>
                </td>
            </tbody>';

            $iteration++;
        };

        $isi = $pala . $output;
        
        return response($isi);
    }

    public function destroy($id)
    {
        $inven = Inventaris::find($id);
        // if ($inven->image) {
        //     Storage::delete($post->image);
        // }
        $inven->delete();
        // User::destroy($user->id);
        return redirect('/inventaris')->with('success', 'Data Inventaris Berhasil di hapus!..');
    }

    public function edit($id)
    {
        // $inven = Inventaris::find($id);
        
        // $post = Post::all()->where('status',['belum', 'proses']);
        return view('dashboard.inventaris.ubah', [
            'title' => 'Update Inventaris',
            "cat" => "home",
            'inven' => Inventaris::find($id)
            
        ]);
    }

    public function update(Request $request, $id)
    {
        $inven = Inventaris::findOrFail($id);
        $validatedDoc = $request->validate([
            'barang' => 'string',
            'serial' => 'string',
            'jenisBarang' => 'string',
            // 'jenis' => [
            //     'required',
            //     Rule::in(['pc','monitor','tv','printer','lain']),
            // ],
            'customJenis' => 'required_if:jenis,lain',
            'merk' => 'string',
            'tanggal' => 'date',
            'kondisi' => [
                
                Rule::in(['baik','rusak ringan','rusak berat']),
            ],
        ]);

        // dd($validatedDoc);
        $inven->where('id', $inven->id)
            ->update($validatedDoc);

            
            return redirect('/inventaris')->with('success', 'Inventaris telah di update!..');
    }
}
