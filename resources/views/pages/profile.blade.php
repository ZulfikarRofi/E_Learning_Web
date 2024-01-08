@extends('layout.master')
@section('page', 'Tambah Soal Kuis')
@section('content')
@if(session('success'))
<div class="alert alert-success m-5">
    {{ session('success') }}
</div>
@endif
@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="card col-lg-8 col-md-6 mb-md-0 mb-4">
    <div class="card-body ">
        <div class="row gx-4 mb-2">
            <div class="col-auto">
                <div class="avatar avatar-xl position-relative">
                    @if($infoUser->jenis_kelamin == 'laki-laki')
                    <img src="../assets/img/man.png" alt="profile">
                    @else
                    <img src="../assets/img/woman.png" class="avatar avatar-sm me-3" alt="profile">
                    @endif
                </div>
            </div>
            <div class="col-auto my-auto">
                <div class="h-100">
                    <h5 class="mb-1 text-capitalize">
                        {{$dataUser->name}}
                    </h5>
                    <p class="mb-0 font-weight-normal text-sm text-capitalize">
                        {{$dataUser->level}}
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card card-plain h-100">
                <div class="card-header pb-0 p-3">
                    <div class="row">
                        <div class="col-md-8 d-flex align-items-center">
                            <h6 class="mb-0">Profile Information</h6>
                        </div>
                        <div class="col-md-4 text-end">
                            <a href="javascript:;">
                                <i class="fas fa-user-edit text-secondary text-sm" data-bs-toggle="modal" data-bs-target="#modal-form-{{$dataUser->id}}"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <p class="text-sm">
                            Hi, I’m Alec Thompson, Decisions: If you can’t decide, the answer is no. If two equally difficult paths, choose the one more painful in the short term (pain avoidance is creating an illusion of equality).
                        </p>
                        <hr class="horizontal gray-light my-1">
                        <div class="col-8">
                            <ul class="list-group">
                                <li class="list-group-item border-0 ps-0 pt-0 text-sm text-capitalize"><strong class="text-dark">Nama Lengkap:</strong> &nbsp; {{$infoUser->name}}</li>
                                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">email:</strong> &nbsp; {{$infoUser->email}}</li>
                                <li class="list-group-item border-0 ps-0 text-sm text-capitalize"><strong class="text-dark">NIP:</strong> &nbsp; {{$infoUser->nip}}</li>
                                <li class="list-group-item border-0 ps-0 text-sm text-capitalize"><strong class="text-dark">TTL:</strong> &nbsp; {{$infoUser->ttl}}</li>
                                <li class="list-group-item border-0 ps-0 text-sm text-capitalize"><strong class="text-dark">Jabatan:</strong> &nbsp; {{$infoUser->jabatan}}</li>
                                <li class="list-group-item border-0 ps-0 text-sm text-capitalize"><strong class="text-dark">Jenis Kelamin:</strong> &nbsp; {{$infoUser->jenis_kelamin}}</li>
                            </ul>
                        </div>
                        <div class="col-4 text-end">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-change-{{$dataUser->id}}">Rubah Password</button>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="modal-form-{{$dataUser->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Ubah Data diri</h5>
                                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="/changePassword/{{$dataUser->id}}" method="post">
                                        @csrf
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Nama lengkap</label>
                                            <input type="text" class="form-control" value="{{$infoUser->name}}" name="name">
                                        </div>
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="text" class="form-control" value="{{$infoUser->email}}" name="name">
                                        </div>
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Tanggal Lahir</label>
                                            <input type="date" class="form-control" value="{{$infoUser->ttl}}" name="name">
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="button" class="btn bg-gradient-primary">Simpan Perubahan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="modal-change-{{$dataUser->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Ubah Passwiord</h5>
                                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="/changePassword/{{$dataUser->id}}" method="post">
                                        @csrf
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Password Lama</label>
                                            <input type="password" class="form-control" name="current_password">
                                        </div>
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Password Baru</label>
                                            <input type="password" class="form-control" name="new_password">
                                        </div>
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Konfirmasi Password</label>
                                            <input type="password" class="form-control" name="new_password_confirmation">
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn bg-gradient-primary">Simpan Perubahan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection