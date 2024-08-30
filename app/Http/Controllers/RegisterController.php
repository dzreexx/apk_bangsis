<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    public function index()
    {
        $admin = Auth::check() ? Auth::user()->role : '';
        // $userRole = Auth::check() ? Auth::user()->role : '';
        if ($admin === 'admin') {
            return view('register.regisadmin', [
                'title' => 'registrasi',
                'role' => $admin,
                'cat' => 'user',
            ]);
        } else {
            return view('register.register', [
                'title' => 'registrasi',
                'role' => $admin,
                'cat' => 'user',
            ]);
        }
    }

    public function search(Request $request)
    {
        $output="";

        $penggunas=User::where('name','Like','%'.$request->search.'%')->
        orWhere('nrp','Like','%'.$request->search.'%')->
        orWhere('id','Like','%'.$request->search.'%')->
        orWhere('pangkat','Like','%'.$request->search.'%')->
        get();

        $bg = "";
        $iteration=1;
        foreach($penggunas as $pengguna)
        {
            if ($pengguna->role == 'empty') {
                $bg = 'text-bg-warning';
            }else {
                $bg = '';
            }

            $output.=
            '<tr>
            <td> '.$iteration.' </td>
            <td> '.$pengguna->name.' </td>
            <td> '.$pengguna->nrp.' </td>
            <td> '.$pengguna->pangkat.' </td>
            <td> '.$pengguna->korp.' </td>
            <td class="'.$bg.'"> '.$pengguna->role.' </td>
            <td> '.$pengguna->created_at.' </td>
            <td> <button class="badge bg-danger border-0" onclick="openDeleteModal('.$pengguna->id.')">
            <i class="bi bi-trash3 text-white"></i>
        </button> </td>
            </tr>';

            $iteration++;
        };
        
        return response($output);
    }

    public function edit()
    {
        $users = User::where('role', 'empty')->get();
        return view('register.requestuser', [
            'title' => 'Request Pengguna',
            'cat' => 'user',
            'users' => $users
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validatedData = $request->validate([
            'role' => [
                Rule::in(['admin','user']),
            ]
        ]);

        // dd($validatedDoc);
        $user->where('id', $user->id)
            ->update($validatedData);

            
            return redirect('/pengguna/request')->with('success', 'akun telah di verifikasi!..');
    }

    public function store(Request $request)
    {
        $admin = Auth::check() ? Auth::user()->role : '';
        if ($admin === 'admin') {
            $validatedDataAdmin = $request->validate([
                'name' => 'required|string',
                'nrp' => 'required|numeric|unique:users',
                'pangkat' => 'required|string',
                'korp' => 'required|string',
                'role' => [
                    Rule::in(['admin','user']),
                ],
                'password' => 'required|min:5'
            ]);
            // dd($validatedData);
            $validatedDataAdmin['password'] = bcrypt($validatedDataAdmin['password']);
    
            User::create($validatedDataAdmin);
            
            // $request->session()->flash('success', 'Registrasi berhasil, silahkan Login.');
    
            return redirect('/pengguna/tambah')->with('success', 'Akun berhasil ditambahkan.');
        } else {
            $validatedData = $request->validate([
                'name' => 'required|string',
                'nrp' => 'required|numeric|unique:users',
                'pangkat' => 'required|string',
                'korp' => 'required|string',
                'jabatan' => 'required|string',
                'gender' => [
                    'required',
                    Rule::in(['laki','perempuan']),
                ],
                'role' => [
                    Rule::in(['admin','user']),
                ],
                'satker' => 'required|string',
                'password' => 'required|min:5'
            ]);
            // dd($validatedData);
            $validatedData['password'] = bcrypt($validatedData['password']);
    
            User::create($validatedData);
            
            // $request->session()->flash('success', 'Registrasi berhasil, silahkan Login.');
    
            return redirect('login')->with('success', 'Registrasi berhasil, silahkan Login.');
        }
    }

    // public function storeadmin(Request $request)
    // {
    //     $validatedDoc = $request->validate([
    //         'name' => 'required|string',
    //         'nrp' => 'required|numeric|unique:users',
    //         'pangkat' => 'required|string',
    //         'korp' => 'required|string',
    //         'gender' => [
    //             'required',
    //             Rule::in(['laki','perempuan']),
    //         ],
    //         'role' => [
    //             Rule::in(['admin','user']),
    //         ],
    //         'satker' => 'required|string',
    //         'password' => 'required|min:5'
    //     ]);

    //     // dd($validatedData);

    //     $validatedDoc['password'] = bcrypt($validatedDoc['password']);

    //     User::create($validatedDoc);
        
    //     // $request->session()->flash('success', 'Registrasi berhasil, silahkan Login.');

    //     return redirect('login')->with('success', 'Akun Berhasil di Tambahkan.');
    // }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->posts()->delete();
        $user->delete();

        // User::destroy($user->id);
        return redirect('/pengguna')->with('success', 'Akun dan semua postingannya Berhasil di hapus!..');
    }
}
