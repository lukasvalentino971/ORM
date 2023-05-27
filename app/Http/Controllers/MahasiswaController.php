<?php

namespace App\Http\Controllers;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswa = Mahasiswa::all(); 
        $posts = Mahasiswa::orderBy('Nim', 'desc')->paginate(5);         
        return view('mahasiswa.index', compact('posts'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mahasiswa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData= $request->validate([ 
            'nim' => 'required', 
            'nama' => 'required', 
            'kelas' => 'required', 
            'jurusan' => 'required', 
            'no_hp' => 'required', 
            'email' => 'required',
            'tgl_lahir' => 'required',
        ]); 
//  dd($validateData);
        Mahasiswa::create($validateData);
        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa Berhasil Ditambahkan');     
    }

    /**
     * Display the specified resource.
     */
    public function show($Nim)
    {
        $Mahasiswa = Mahasiswa::find($Nim); 
        // dd($Mahasiswa);
        return view('mahasiswa.detail', compact('Mahasiswa'));
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($Nim)
    {
        $Mahasiswa = Mahasiswa::find($Nim); 
        return view('mahasiswa.edit', compact('Mahasiswa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $Nim)
    {
        $validatedData = $request->validate([ 
            'nim' => 'required', 
            'nama' => 'required', 
            'kelas' => 'required', 
            'jurusan' => 'required', 
            'no_hp' => 'required',
            'email' => 'required',
            'tgl_lahir' => 'required',
        ]);
        Mahasiswa::find($Nim)->update($validatedData);  
        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($Nim)
    {
        Mahasiswa::find($Nim)->delete(); 
        return redirect()->route('mahasiswa.index')-> with('success', 'Mahasiswa Berhasil Dihapus'); 
    }
}