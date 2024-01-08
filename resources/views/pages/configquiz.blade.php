@extends('layout.master')
@section('page', 'Konfigurasi Kuis')
@section('content')

<div class="col-lg-8 col-md-6 mb-md-0 mb-4">
    <div class="card">

        <div class="card-header pb-0">
            <div class="row">
                <div class="col-lg-6 col-7">
                    <h6>Konfigurasi Kuis</h6>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h6>Daftar Opsi Soal</h6>
                <a href="/addQuestion/{{$kuis->id}}"><button class="btn btn-primary"> Tambah Soal</button></a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th class="fw-bold text-xxl text-center">No</th>
                        <th class="fw-bold text-xxl text-center">Isi Soal</th>
                        <th class="fw-bold text-xxl text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($questions as $q)
                    <tr>
                        <td class="text-xxl"><a href="/detailSoal/{{$q->id}}">{{$loop->iteration}}</a></td>
                        <td class="text-xxl" style="max-width: 700px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; max-height: 20px; overflow: hidden; text-overflow: ellipsis; white-space: normal; line-height: 20px;"><a href="/detailSoal/{{$q->id}}">{!!$q->question_text!!}</a></td>
                        <td class="align-middle">
                            <div class="d-flex">
                                <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                    <i class="material-icons opacity-10">edit</i>
                                </a>
                                <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                    <i class="material-icons opacity-10">delete</i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
