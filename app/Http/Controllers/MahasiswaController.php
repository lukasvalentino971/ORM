<?php

namespace App\Http\Controllers;
use App\Models\Mahasiswa;
use App\Models\Kelas;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $mahasiswa = Mahasiswa::with('kelas')->orderBy('nim', 'desc');
        if ($request->get('s')) {
            $mahasiswa = $mahasiswa->where('nama', 'LIKE', '%'.$request->get('s').'%');
        }

        $mahasiswa = $mahasiswa->paginate(5);
        return view('mahasiswa.index', compact('mahasiswa'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = Kelas::all();
        return view('mahasiswa.create', compact('kelas'));

        // return view('mahasiswa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([ 
            'nim' => 'required', 
            'nama' => 'required', 
            'kelas_id' => 'required', 
            'jurusan' => 'required',
            'no_hp' => 'required',
            'email' => 'required',
            'tgl_lahir' => 'required',
        ]); 
        $mahasiswa = new Mahasiswa;
        $mahasiswa->nim = $request->get('nim');
        $mahasiswa->nama = $request->get('nama');
        $mahasiswa->jurusan = $request->get('jurusan');
        $mahasiswa->save();
        
        $kelas = new Kelas;
        $kelas->id = $request->get('kelas');

        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();
        
        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa Berhasil Ditambahkan');     
    }

    /**
     * Display the specified resource.
     */
    public function show($Nim)
    {

        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();

        return view('mahasiswa.detail', ['Mahasiswa' => $mahasiswa]);
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($Nim)
    {
        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
        $kelas = Kelas::all();
        return view('mahasiswa.edit', compact('mahasiswa', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $Nim)
    {
        $request->validate([ 
            'nim' => 'required', 
            'nama' => 'required', 
            'kelas_id' => 'required', 
            'jurusan' => 'required', 
            'no_hp' => 'required',
            'email' => 'required',
            'tgl_lahir' => 'required',
        ]);

        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
        $mahasiswa->nim = $request->get('nim');
        $mahasiswa->nama = $request->get('nama');
        $mahasiswa->jurusan = $request->get('jurusan');
        $mahasiswa->save();

        $kelas = new Kelas;
        $kelas->id = $request->get('kelas_id');

        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();

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