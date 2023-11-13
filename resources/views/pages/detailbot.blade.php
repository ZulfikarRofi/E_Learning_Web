@extends('layout.masadmin')
@section('page', 'Detail Bot')
@section('content')

<div class="row mb-3 mx-1 vh-100">
    <div class="card">
        <div class="card-header pb-0">
            <div class="">
                <div class="d-flex justify-content-between">
                    <h6>Bot - {{$dataBot->nama_bot}} | {{$dataBot->nama_mapel}} Kelas {{$dataBot->nama_kelas}}</h6>
                    @if($listSiswa->isEmpty())
                    <button class="btn btn-danger pointer">Status Non Aktif</button>
                    @else
                    <span class="badge bg-success text-center text-xxs pb-0 pt-2 m-0">Status Aktif</span>
                    @endif
                </div>
                <p class="text-sm mb-0">
                    Konfigurasi Bot untuk chatbot siswa
                </p>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center text-capitalize">No</th>
                        <th class="text-center text-capitalize">Nama Siswa</th>
                        <th class="text-center text-capitalize">NIS</th>
                        <th class="text-center text-capitalize">Jenis Kelamin</th>
                        <th class="text-center text-capitalize">Kelas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listSiswa as  $lS)
                    <tr>
                        <td class="text-sm text-center text-capitalize">{{$loop->iteration}}</td>
                        <td class="text-sm text-center text-capitalize">{{$lS->name}}</td>
                        <td class="text-sm text-center text-capitalize">{{$lS->nis}}</td>
                        <td class="text-sm text-center text-capitalize">{{$lS->jenis_kelamin}}</td>
                        <td class="text-sm text-center text-capitalize">{{$lS->nama_kelas}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
