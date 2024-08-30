<?php

namespace App\Http\Controllers;

use App\Models\UserAdmin;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class RegisAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userRole = Auth::check() ? Auth::user()->role : '';
        return view('register.regisadmin', [
            'title' => 'registrasi',
            'role' => $userRole,
            'cat' => 'user'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
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
        $validatedData['password'] = bcrypt($validatedData['password']);

        UserAdmin::create($validatedData);
        
        // $request->session()->flash('success', 'Registrasi berhasil, silahkan Login.');

        return redirect('/pengguna/tambah')->with('success', 'Registrasi berhasil, silahkan Login.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(UserAdmin $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(UserAdmin $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserAdmin $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserAdmin $user)
    {
        //
    }
}
