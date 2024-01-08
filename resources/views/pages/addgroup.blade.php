@extends('layout.masteradmin')
@section('page', 'Tambah Soal Kuis')
@section('content')

<div class="card">

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
                <h6>Tambah Group Baru</h6>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form action="/storeGroup" method="post">
            @csrf
            <div class="row mb-3">
                <div class="col-12">
                    <div class="input-group input-group-outline my-4">
                        <label class="form-label">Nama Group</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class=" btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection