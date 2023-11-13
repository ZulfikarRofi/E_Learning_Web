@extends('layout.master')
@section('page', 'Dashboard')
@section('content')

<div class="col-lg-8 col-md-6 mb-md-0 mb-4">
    <div class="card ">
        <div class="card-header pb-0">
            <div class="row">
                <div class="col-lg-6 col-7">
                    <h4>Materi Pelajaran</h4>
                    <p class='passive-text text-capitalize'>@if($userdata->jenis_kelamin == 'perempuan')Bu @else Pak @endif {{$userdata->nama_guru}}</p>
                </div>
            </div>
        </div>
        <div class="card-body px-0 pb-2">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7" style="width: 20%;">Nama Mapel</th>
                            <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">Kelas</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID Mapel</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jadwal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($dataMapel)
                        @foreach($dataMapel as $dm)
                        <tr>
                            <td>
                                <div class="d-flex justify-content-between align-items-center px-2 py-1">
                                    <img src="../assets/img/icons/png/binder.png" class="avatar avatar-sm me-3" alt="xd">
                                    <span class="text-secondary text-sm font-weight-bolder text-center justify-content-center">
                                        <a href="/detail/matapelajaran/{{$dm->id}}">{{$dm->nama_mapel}}</a>
                                    </span>
                                </div>
                            </td>
                            <td class="align-middle text-center text-sm">
                                <span class="text-sm font-weight-bold"> {{$dm->nama_kelas}} </span>
                            </td>
                            <td class="align-middle text-center text-sm">
                                <span class="text-sm font-weight-bold"> {{$dm->mapel_id}} </span>
                            </td>
                            <td class="align-middle text-center">
                                <span class="text-sm font-weight-bold  text-capitalize"> {{$dm->hari_pelajaran}} :
                                    @foreach(json_decode($dm->jam_pelajaran) as $value)
                                    {{$value}}
                                    @endforeach
                                </span>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
        </div>
    </div>
</div>
@endsection
