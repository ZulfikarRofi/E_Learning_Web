@extends('layout.master')
@section('page', 'Hasil Perolehan Tugas')
@section('content')

<div class="card">
<div class="card-header">
    <h6 class="fw-bold">Hasil perolehan tugas mata pelajaran {{$ht->nama_mapel}} kelas {{$ht->nama_kelas}}</h6>
</div>
<div class="card-body">
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>NIS</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dataHasilTugas $dht)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$dht->name}}</td>
                <td>{{$dht->nis}}</td>
                <td>{{$dht->status}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>

@endsection
