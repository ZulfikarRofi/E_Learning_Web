@extends('layout.master')
@section('page', 'Halaman Materi')
@section('content')

<div class="col-lg-8 col-md-6 mb-md-0 mb-4">
    <div class="card">
        <div class="card-header pb-0">
            <div class="row">
                <div class="col-lg-6 col-7">
                    <h6>Modul oleh {{auth()->user()->name}}</h6>
                    <p class="text-sm mb-0">
                        <i class="fa fa-check text-info" aria-hidden="true"></i>
                        <span class="font-weight-bold ms-1">{{$tM}} Modul Selesai</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="card-body px-0 pb-2">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Judul</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Modul ID</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Tanggal</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Matapelajaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modul as $m)
                        <tr>
                            <td style="width: 40%">
                                <div class="d-flex px-2 py-1">
                                    <div>
                                        <img src="../assets/img/icons/png/book.png" class="avatar avatar-sm me-3" alt="xd">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center" style="width: 40%">
                                        <h6 class="mb-0 text-sm"><a href="/detail/modul/{{$m->id}}">{{$m->judul}}</a></h6>
                                    </div>
                                </div>
                            </td>
                            <td >
                                @if(empty($m->modul_number))
                                    <span class="text-sm">
                                        tidak teregistrasi
                                    </span>
                                @endif
                                <span class="text-sm">
                                    {{$m->modul_number}}
                                </span>
                            </td>
                            <td>
                                <span class="text-sm">{{$m->tanggal_regis}}</span>
                            </td>
                            <td>
                                <span class="text-sm">{{$m->nama_mapel}}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
