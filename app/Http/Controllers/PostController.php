<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;


class PostController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $post = $user->posts;

        return view('permintaan', [
            "title" => "Permintaan Aplikasi",
            "cat" => "home",
            "users" => $user,
            // "posts" => Post::all()
            // "posts" => Post::latest()->get()
            "posts" => $post
        ]);
    }

    public function dokumen($id)
    {
        return view('dokumen', [
            "title" => "dokumen",
            "cat" => "home",
            "post" => post::find($id)

        ]);
    }

    public function ubah($id)
    {
        $user = User::all();

        return view('dashboard.dataform.ubah',[
            'title' => 'Ubah Permintaan Aplikasi',
            "users" => $user,
            "cat" => "home",
            'posts' => Post::find($id)
        ]);
    }

    public function ubahData(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $validatedDoc = $request->validate([
            'perihal' => 'required|min:5|max:255',
            'tanggal' => 'required|date',
            'tujuan' => 'required',
            'status' => '',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->file('image')) {
            if($request->oldImage){
                Storage::delete($request->oldImage);
            }
            $validatedDoc['image'] = $request->file('image')->store('post-image', 'public');
        }

        // dd($validatedDoc);
        $post->where('id', $post->id)
            ->update($validatedDoc);

            
            return redirect('/permintaan')->with('success', 'Permintaan telah di ubah!..');
    }

    public function lihat()
    {  
        $post = Post::where('status', 'proses')->orWhere('status' , 'selesai')->get();
        return view('lihatpermintaan', [
            'title' => 'Lihat Permintaan',
            "cat" => "home",
            // 'doks' => Post::latest()->get()
            'doks' => $post
        ]);
    }

    public function search(Request $request)
    {
        $output="";

        $doks=Post::where('perihal','Like','%'.$request->search.'%')->
        orWhere('tanggal','Like','%'.$request->search.'%')->
        orWhere('status','Like','%'.$request->search.'%')->
        get();

        $iteration = 1;

        foreach($doks as $dok)
        {
            $bg = ($dok->status == 'proses') ? 'text-bg-info' : 'text-bg-success';
            $isi = ($dok->status == 'proses') ? 'Proses' : 'Selesai';

            $output.=
            '<tr>
            <td> '.$iteration.' </td>
            <td> '.$dok->perihal.' </td>
            <td> '.$dok->tanggal.' </td>
            <td> '.$dok->user->satker.' </td>
            <td> '.$dok->created_at.' </td>
            <td class='.$bg.'> '.$isi.' </td>
            <td><a href="/dokumen/'.$dok->id.'" target="_blank">Lihat</a></td>
            </tr>';

            $iteration++;
        };
        
        return response($output);
    }

    public function data()
    {
        $user = User::all();

        return view('dashboard.dataform.data',[
            'title' => 'Permintaan Aplikasi Input',
            "users" => $user,
            "cat" => "home"
        ]);
    }

    public function store(Request $request)
    {
        $validatedDoc = $request->validate([
            'user_id' => 'required|numeric',
            'perihal' => 'required|min:5|max:255',
            'tanggal' => 'required|date',
            'tujuan' => 'required',
            'status' => [
                Rule::in(['belum','proses','selesai','tolak']),
            ],
            'keterangan' => '',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $validatedDoc['image'] = $request->file('image')->store('post-image', 'public');
        // return request()->all();
        // $file = $request->file('file');
        // $fileData = file_get_contents($file);
        // dd('data terkirim');
        Post::create($validatedDoc);

        return redirect('/permintaan')->with('success', 'Dokumen Berhasil di buat!');
    }


    public function destroy($id)
    {
        $post = Post::find($id);
        if ($post->image) {
            Storage::delete($post->image);
        }
        $post->delete();
        // User::destroy($user->id);
        return redirect('/kelola')->with('success', 'Request permintaan Berhasil di hapus!..');

        // Post::destroy($post->id);

        // return redirect('/request')->with('success', 'Dokumen Berhasil di hapus!');
    }

    public function edit()
    {
        $post = Post::where('status', 'belum')->orWhere('status' , 'proses')->get();
        
        // $post = Post::all()->where('status',['belum', 'proses']);
        return view('kelola', [
            'title' => 'Kelola Aplikasi',
            "cat" => "user",
            'doks' => $post
            
        ]);
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $validatedDoc = $request->validate([
            'status' => [
                Rule::in(['belum','proses','selesai','tolak']),
            ],
            'keterangan' => '',
        ]);

        // dd($validatedDoc);
        $post->where('id', $post->id)
            ->update($validatedDoc);

            
            return redirect('/kelola')->with('success', 'Status telah di update!..');
    }

}
