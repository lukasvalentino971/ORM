@extends('mahasiswa.layout')

@section('content')

<div class="container mt-5">

    <div class="row justify-content-center align-items-center">
        <div class="card" style="width: 24rem;">
            <div class="card-header">
                Edit Mahasiswa
            </div>
            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your i nput.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form method="post" action="{{ route('mahasiswa.update', $Mahasiswa->nim) }}" id="myForm">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="Nim">Nim</label> <input type="text" name="nim" class="formcontrol" id="Nim"
                            value="{{ $Mahasiswa->nim }}" ariadescribedby="Nim">
                    </div>
                    <div class="form-group">
                        <label for="Nama">Nama</label> <input type="text" name="nama" class="formcontrol" id="Nama"
                            value="{{ $Mahasiswa->nama }}" ariadescribedby="Nama">
                    </div>
                    <div class="form-group">
                        <label for="Kelas">Kelas</label> <input type="Kelas" name="kelas" class="formcontrol" id="Kelas"
                            value="{{ $Mahasiswa->kelas }}" ariadescribedby="Kelas">
                    </div>
                    <div class="form-group">
                        <label for="Jurusan">Jurusan</label> <input type="Jurusan" name="jurusan" class="formcontrol"
                            id="Jurusan" value="{{ $Mahasiswa->jurusan }}" ariadescribedby="Jurusan">
                    </div>
                    <div class="form-group">
                        <label for="No_Handphone">No_Handphone</label>
                        <input type="No_Handphone" name="no_hp" class="formcontrol" id="No_Handphone"
                            value="{{ $Mahasiswa->no_hp}}" ariadescribedby="No_Handphone">
                    </div>
                    <div class="form-group">
                        <label for="Email">Email</label>
                        <input type="Email" name="email" class="formcontrol" id="Email" value="{{ $Mahasiswa->email}}"
                            ariadescribedby="email">
                    </div>
                    <div class="form-group">
                        <label for="Tanggal_Lahir">Tanggal Lahir</label>
                        <input type="date" name="tgl_lahir" class="formcontrol" id="Tanggal_Lahir"
                            value="{{ $Mahasiswa->tgl_lahir}}" ariadescribedby="Tanggal_Lahir">
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div> @endsection