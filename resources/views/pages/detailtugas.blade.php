@extends('layout.masteradmin')
@section('page', 'Tugas')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header pb-0">
            <div class="row">
                <div class="col-6">
                    <h4>{{$task->nama_tugas}}</h4>
                    <p>{{$task->number_tugas}}</p>
                </div>
                <div class="col-6 pe-3 pt-3">
                    <div class="text-end">
                        <span class="fw-bold">Tenggat Waktu :</span><span class="fw-semibold">{{$task->due_date}}</span>
                        <p class="fw-semibold text-secondary">Di posting pada :{{$task->tanggal_regis}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="description-box px-5">
                    <p class="fw-light text-justify">
                        {!!$task->deskripsi_tugas!!}
                    </p>
                    <small class="fw-bold text-capitalize">Author : <span>{{$task->nama_guru}}</span></small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
