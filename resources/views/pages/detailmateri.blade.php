@extends('layout.masteradmin')
@section('page', 'Modul')
@section('content')


<div class="container">
    @foreach($selectedModul as $sm)
    <div class="card">
        <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
                <div>
                    <h4>{{$sm->judul}}</h4>
                    <p>{{$sm->nama_modul}}</p>
                </div>
                <div class="d-flex flex-column justify-content-between align-items-end">
                    <small class="fw-bold">Author : <span>{{$sm->nama_guru}}</span></small>
                    <button class="btn btn-danger d-flex justify-content-center" style="width: 20%;" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="material-icons opacity-10">delete</i></button>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Yakin ingin menghapus materi ini ? <span class="fw-bold">{{$sm->nama_modul}}</span>
                    </div>
                    <form action="/deleteModul/{{$sm->id}}" method="post">
                        @csrf
                        @method('DELETE')
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn bg-gradient-primary">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <!-- <div class="row mb-3">
                <div class="col-4 text-end">
                    <img src="/assets/img/icons/png/no-photos.png" alt="no image" style="width:80%">
                </div>
            </div> -->
            <div class="row">
                <div class="description-box px-5">
                    <p class="fw-light text-justify">
                        {!!$sm->deskripsi!!}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
