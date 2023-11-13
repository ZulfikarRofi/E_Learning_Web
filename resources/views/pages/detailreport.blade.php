@extends('layout.master')
@section('page', 'Hasil Kuis')
@section('content')

<div class="col-lg-8 col-md-6 mb-md-0 mb-4">
    <div class="card">
        <div class="card-header pb-0">
            <div class="row">
                <div class="d-flex justify-content-between">
                    <div class="judul">
                        <h4>{{$dataReport->nama_kuis}}</h4>
                        <p>Kelas - <span class="fw-bold text-primary">{{$dataReport->nama_kelas}}</span></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <p class="text-secondary fw-semibold fs-6">Hasil perolehan kuis siswa kelas {{$dataReport->nama_kelas}}</p>
            <table class="table">
                <thead>
                    <tr>
                        <th class="fw-semibold text-xs text-center">Nama Siswa</th>
                        <th class="fw-semibold text-xs text-center">Nis</th>
                        <th class="fw-semibold text-xs text-center">Total Benar</th>
                        <th class="fw-semibold text-xs text-center">Total Salah</th>
                        <th class="fw-semibold text-xs text-center">Skor</th>
                        {{-- <th class="fw-semibold text-xs">Ranking</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataNilai as $dN)
                    <tr>
                        <td class="text-xs text-capitalize text-center">{{$dN->name}}</td>
                        <td class="text-xs text-capitalize text-center">{{$dN->nis}}</td>
                        <td class="text-xs text-capitalize text-center">{{$dN->total_benar}}</td>
                        <td class="text-xs text-capitalize text-center">{{$dN->total_salah}}</td>
                        <td class="text-xs text-capitalize text-center">{{$dN->skor}}</td>
                        {{-- <td>{{$dN->ranking}}</td> --}}
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
