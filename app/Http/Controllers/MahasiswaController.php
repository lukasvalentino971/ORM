<?php

namespace App\Http\Controllers;
use App\Models\Mahasiswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDF;

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
            'foto' => 'mimes:jpg,png,jpeg',
            'kelas_id' => 'required', 
            'jurusan' => 'required',
            'no_hp' => 'required',
            'email' => 'required',
            'tgl_lahir' => 'required',
        ]); 
        $mahasiswa = new Mahasiswa;
        $mahasiswa->nim = $request->get('nim');
        $mahasiswa->nama = $request->get('nama');
        $mahasiswa->foto = $nama_foto;
        $mahasiswa->kelas_id = $request->get('kelas');
        $mahasiswa->Jurusan = $request->get('jurusan');
        $mahasiswa->no_hp = $request->get('no_hp');
        $mahasiswa->email = $request->get('email');
        $mahasiswa->tgl_lahir = $request->get('tgl_lahir');
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
            'foto' => 'mimes:jpg,png,jpeg',
            'kelas_id' => 'required', 
            'jurusan' => 'required', 
            'no_hp' => 'required',
            'email' => 'required',
            'tgl_lahir' => 'required',
        ]);

        $mahasiswa = Mahasiswa::find($Nim);

        // $mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
        // $mahasiswa->nim = $request->get('nim');
        // $mahasiswa->nama = $request->get('nama');
        // $mahasiswa->jurusan = $request->get('jurusan');
        // $mahasiswa->save();

        if ($mahasiswa->foto && file_exists(storage_path('app/public/' . $mahasiswa->foto))) {
            Storage::delete('public/' . $mahasiswa->foto);
        }

        $nama_foto = $request->file('foto')->store('fotoMahasiswa');
        
        Mahasiswa::where('Nim', $Nim)->update([
            'nim' => $request->get('nim'),
            'nama' => $request->get('nama'),
            'foto' => $nama_foto,
            'jurusan' => $request->get('jurusan'),
            'no_hp' => $request->get('no_hp'),
            'email' => $request->get('email'),
            'tgl_lahir' => $request->get('tgl_lahir'),
            'kelas_id' => $request->get('kelas'),
        ]);

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

    public function khs(Mahasiswa $mahasiswa)
    {
        $matkul = $mahasiswa->mataKuliah;

        return view('mahasiswa.khs', [
            'mahasiswa' => $mahasiswa,
            'matkuls' => $matkul
        ]);
    }

    public function cetak_khs(Mahasiswa $mahasiswa)
    {
        $matkuls = $mahasiswa->matakuliah;
        $pdf = PDF::loadview('mahasiswa.cetak_khs', [
            'matkuls' => $matkuls,
            'mahasiswa' => $mahasiswa,
        ]);
        return $pdf->stream();
    }

}