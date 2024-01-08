@extends('layout.master')
@section('page', 'Tambah Soal Kuis')
@section('content')


<div class="card col-8">

    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card-header pb-0">
        <div class="row">
            <div class="d-flex justify-content-between">
                <h6>Tambah Data Bot</h6>
            </div>
        </div>
    </div>
    <div class="card-body">
        <!-- Modal -->
        <div class="modal fade" id="tambahMapel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Tambah Mata Pelajaran Baru</h5>
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/storeBotOption" method="post">
                        <div class="modal-body">
                            @csrf
                            <div class="col-12">
                                <div class="input-group input-group-outline">
                                    <label class="form-label">Isi Opsi Bot</label>
                                    <input type="text" class="form-control" name="isiBotOption">
                                </div>
                                <select name="" id=""></select>
                                <input type="number" name="idSoal" value="{{$soal->id}}" hidden>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn bg-gradient-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
