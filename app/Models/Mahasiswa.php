<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Mahasiswa as Authenticatable;
use Illuminate\Notifications\Notifiable; 
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table="mahasiswa";
    // public $timestamps= false;
    protected  $primaryKey = 'nim'; 
    public $timestamps = false;

    protected $fillable = [
        'nim',
        'nama',
        'jurusan',
        'no_hp',
        'email',
        'tgl_lahir',
        'kelas_id',
    ];

    public function kelas(){
        return $this->belongsTo(Kelas::class);
    }

}