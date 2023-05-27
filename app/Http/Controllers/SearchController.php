<?php

namespace App\Http\Controllers;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SearchController extends Controller
{
    public function cari(Request $request){

    $cari = $request->search;
    $posts = Mahasiswa::where('nama', 'LIKE', '%'. $cari . "%")->paginate(5);
    return view('mahasiswa.index', ['posts'=> $posts]);
}
}