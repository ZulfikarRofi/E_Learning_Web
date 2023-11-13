@extends('layout.master')
@section('page', 'Halaman Kuis')
@section('content')
<div class="col-lg-8 col-md-6 mb-md-0 mb-4">
    <div class="card">
        <div class="card-header pb-0">
            <div class="row">
                <div class="col-lg-6 col-7">
                    <h6>Daftar Kuis</h6>
                    <p class="text-sm mb-0">
                        <i class="fa fa-check text-info" aria-hidden="true"></i>
                        <span class="font-weight-bold ms-1">{{$totalKuis}} Kuis  </span>Telah Terpublikasikan
                    </p>
                </div>
                <div class="col-lg-6 col-5 my-auto text-end">
                    <div class="dropdown float-lg-end pe-4">
                        <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-ellipsis-v text-secondary"></i>
                        </a>
                        <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">
                            <li><a class="dropdown-item border-radius-md" href="/addquiz">Tambah Kuis</a></li>
                            <li><a class="dropdown-item border-radius-md" href="javascript:;">Another action</a></li>
                            <li><a class="dropdown-item border-radius-md" href="javascript:;">Something else here</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body px-0 pb-2">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 33%;">Nama Kuis</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" style="width: 33%;">Nomor Kuis</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 33%;">Tenggat Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allKuis as $k)
                        <tr>
                            <td style="width: 33%;">
                                <div class="d-flex px-2 py-1">
                                    <div>
                                        <img src="../assets/img/icons/png/test.png" class="avatar avatar-sm me-3" alt="xd">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm"><a href="/detail/kuis/{{$k->id}}">Kuis: {{$k->nama_kuis}}</a></h6>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle text-center text-sm" style="width: 33%;">
                                <span class="text-xs text-secondary font-weight-bold">{{$k->kuis_number}}</span>
                            </td>
                            <td class="align-middle">
                                <div class="progress-wrapper w-75 mx-auto" style="width: 33%;">
                                    <div>
                                        <span class="text-xs font-weight-bold">{{$k->duedate}}</span>
                                    </div>
                                </div>
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
