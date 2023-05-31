<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDF;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->file('image')){
            $image_name = $request->file('image')->store('image', 'public');
        }

        Article::create([
            'title' => $request->title,
            'content' => $request->content,
            'featured_image' => $image_name,
        ]);
        return 'Artikel berhasil disimpan';
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        dd('ets');
        return 'tes';
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        //
        return view('articles.edit', ['article' => $article]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        //
        $article->title = $request->title;
        $article->content = $request->content;

        if ($article->featured_image && file_exists(storage_path('app/public/' . $article->featured_image))) {
            Storage::delete('public/' . $article->featured_image);
        } else {
            dd('gagal');
        }

        $image_name = $request->file('image')->store('images', 'public');
        $article->featured_image = $image_name;

        $article->save();
        return 'Artikel berhasil diubah';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        //
    }

    public function khs(Mahasiswa $mahasiswa)
    {
        $matkuls = $mahasiswa->matakuliah;

        return view('mahasiswa.khs', [
            'matkuls' => $matkuls,
            'mahasiswa' => $mahasiswa
        ]);
        // dd($matkuls);

        // $role = Mahasiswa::where('Nim', '2141720039')->first();

        // dd($role->matakuliahs);


        // dd($data);
    }

    public function cetak_khs(Mahasiswa $mahasiswa)
    {
        $matkuls = $mahasiswa->matakuliah;
        $pdf = pdf::loadview('mahasiswa.cetak_khs', [
            'matkuls' => $matkuls,
            'mahasiswa' => $mahasiswa,
        ]);
        return $pdf->stream();
    }
}