@extends('layout.master')
@section('page', 'Tambah Kelas Baru')
@section('content')

<div class="col-lg-8 col-md-6 mb-md-0 mb-4">
    <div class="card">
        <div class="card-header pb-0">
            <div class="row">
                <div class="col-lg-6 col-7">
                    <h6>Tambah Kelas Baru</h6>
                    <small>Masukkan data sesuai dengan formulir yang tertera</small>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form role="form">
                <div class="input-group input-group-outline mb-3 mx-1">
                    <label class="form-label">Nama Kelas</label>
                    <input type="text" class="form-control">
                </div>
                <select class="form-select mb-3 mx-1" aria-label="Default select example">
                    <option selected>Pilih Kategori Kelas</option>
                    <option value="1">VII</option>
                    <option value="2">VIII</option>
                    <option value="3">IX</option>
                </select>
                <select class="form-select mb-3 mx-1" aria-label="Default select example">
                    <option selected>Pilih Wali Kelas</option>
                    <option value="1">Andriyani, S.Pd.</option>
                    <option value="2">Wahyudi, S.Pd.</option>
                    <option value="3">Nurrohman, S.Kom.</option>
                </select>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection