<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Http\Request;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ArticleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('mahasiswa/{mahasiswa}/khs', [MahasiswaController::class, 'khs'])->name('mahasiswa.cetak_khs');

Route::resource('mahasiswa', MahasiswaController::class);

Route::get('/articles/{mahasiswa}/cetak_khs', [MahasiswaController::class, 'cetak_khs'])->name('mahasiswa.pdf');
Route::get('search', [SearchController::class, 'cari']);

Route::resource('articles', ArticleController::class);