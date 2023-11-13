@extends('layout.master')
@section('page', 'Daftar Tugas')
@section('content')

<div class="col-lg-8 col-md-6 mb-md-0 mb-4">
    <div class="card">
        <div class="card-header pb-0">
            <div class="row">
                <div class="col-lg-6 col-7">
                    <h6>Daftar Tugas</h6>
                    <p class="text-sm mb-0">
                        <i class="fa fa-check text-info" aria-hidden="true"></i>
                        <span class="font-weight-bold ms-1">{{$total_task}} Tugas Terpublikasikan </span>
                    </p>
                </div>
            </div>
        </div>
        <div class="card-body px-0 pb-2">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 20%;">Nama Tugas</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" style="width: 20%;">Nomor Tugas</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 20%;">Mata Pelajaran</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 20%;">Kelas</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 20%;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($task as $t)
                        <tr>
                            <td style="width: 20%;">
                                <div class="d-flex px-2 py-1">
                                    <div>
                                        <img src="../assets/img/icons/png/test.png" class="avatar avatar-sm me-3" alt="xd">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm"><a href="/detail/tugas/{{$t->id}}">{{$t->nama_tugas}}</a></h6>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle text-center text-sm" style="width: 20%;">
                                <span class="text-xs text-secondary font-weight-bold">{{$t->number_tugas}}</span>
                            </td>
                            <td class="align-middle text-center text-sm" style="width: 20%;">
                                <span class="text-xs text-secondary font-weight-bold">{{$t->nama_mapel}}</span>
                            </td>
                            <td class="align-middle text-center text-sm" style="width: 20%;">
                                <span class="text-xs text-secondary font-weight-bold">{{$t->nama_kelas}}</span>
                            </td>
                            <td class="align-middle text-center text-sm" style="width: 20%;">
                                <span class="text-xs text-secondary font-weight-bold text-capitalize">{{$t->status}}</span>
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
