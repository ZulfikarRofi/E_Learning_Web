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
                <h6>Tambah Soal Baru</h6>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form action="/storeOpsi" method="post">
            @csrf
            <div class="row mb-3">
                <div class="col-12">
                    <div class="input-group input-group-outline">
                        <label class="form-label">Isi Opsi</label>
                        <input type="text" class="form-control" name="isiOpsi">
                    </div>
                    <input type="number" name="idSoal" value="{{$soal->id}}" hidden>
                </div>
            </div>
            <div class="mb-3">
                <select name="status" class="form-select ps-2 text-capitalize text-secondary text-sm font-weight-normal">
                    <option value="" class="text-center">--- Pilih Status Opsi ---</option>
                    <option value="true" class="text-center">Benar</option>
                    <option value="false" class="text-center">Salah</option>
                </select>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class=" btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>

@endsection
