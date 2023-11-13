@extends('layout.masteradmin')
@section('page', 'Daftar Pengguna')
@section('content')
<div class="container-fluid py-4">
    @if($errors->any())
    <div class="alert alert-danger" role="alert">
        Oops! some input is wrong
        @foreach($errors->all() as $error)
        <li class="text-red-500 list-none">
            {{ $error }}
        </li>
        @endforeach
    </div>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <div class="d-flex justify-content-between">
                            <h6 class="text-white text-capitalize ps-3">Daftar Guru</h6>
                            <div class="dropdown pe-3">
                                <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v text-white fw-bolder"></i>
                                </a>
                                <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">
                                    <li><a class="dropdown-item border-radius-md" data-bs-toggle="modal" data-bs-target="#tambahguru">Tambah Guru</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="tambahguru" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Tambah Guru</h5>
                                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="/storeAddGuru" method="post">
                                    @csrf
                                    <div class="input-group input-group-outline mb-3">
                                        <label for="" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" name="nama_guru">
                                    </div>
                                    <div class="input-group input-group-outline mb-3">
                                        <label for="" class="form-label">Email</label>
                                        <input type="text" class="form-control" name="email">
                                    </div>
                                    <div class="input-group input-group-outline mb-3">
                                        <label for="" class="form-label">Nomor Induk Pengajar</label>
                                        <input type="text" class="form-control" name="nip">
                                    </div>
                                    <div class="input-group input-group-outline mb-3">
                                        <label for="" class="form-label">Jabatan</label>
                                        <input type="text" class="form-control" name="jabatan">
                                    </div>
                                    <div class="input-group input-group-static my-3">
                                        <label>Tanggal Lahir</label>
                                        <input type="date" class="form-control" name="ttl">
                                    </div>
                                    <div class="input-group input-group-static mb-2">
                                        <label for="exampleFormControlSelect1" class="ms-0">Jenis Kelamin</label>
                                        <select class="form-control" name="jenis_kelamin">
                                            <option value="laki-laki">Laki-Laki</option>
                                            <option value="perempuan">Perempuan</option>
                                        </select>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn bg-gradient-primary">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Foto</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">NIP</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tahun Aktif</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($guru as $gr)
                                <tr>
                                    <td class="text-center">
                                        <div>
                                            @if(empty($gr->photo))
                                            @if($gr->jenis_kelamin == 'laki-laki')
                                            <img src="../assets/img/man.png" class="avatar avatar-sm me-3" alt="profile">
                                            @else
                                            <img src="../assets/img/woman.png" class="avatar avatar-sm me-3" alt="profile">
                                            @endif
                                            @else
                                            <img src="../assets/upload-img/{{$gr->photo}}" class="avatar avatar-sm me-3 border-radius-lg" alt="profile">
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{$gr->nama_guru}}</h6>
                                                <p class="text-xs text-secondary mb-0">{{$gr->email}}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{$gr->nip}}</p>
                                        <p class="text-xs text-secondary mb-0">{{$gr->jenis_kelamin}}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-secondary text-xs font-weight-bold">{{$gr->jabatan}}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">2015</span>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex">
                                            <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                                <i class="material-icons opacity-10">edit</i>
                                            </a>
                                            <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                                <i class="material-icons opacity-10">delete</i>
                                            </a>
                                            <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="material-icons opacity-10">more_horiz</i>
                                            </a>
                                            <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">
                                                <!-- Create Account trigger modal -->
                                                <li>
                                                    <a data-bs-toggle="modal" data-bs-target="#createaccountmodal{{$gr->id}}">Buat Akun</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Modal -->
                                <div class="modal fade" id="createaccountmodal{{$gr->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <form action="/createAccount" method="post">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Buat Akun</h5>
                                                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <span>Apakah anda yakin ingin membuatkan akun pada guru ini ? <span class="fw-bold">"{{$gr->nama_guru}}"</span></span>
                                                    <input type="email" name="email" value="{{$gr->email}}" hidden>
                                                    <input type="text" name="name" value="{{$gr->nama_guru}}" hidden>
                                                    <input type="text" name="guru_id" value="{{$gr->id}}" hidden>
                                                    <input type="text" name="password" value="{{$gr->nip}}" hidden>
                                                    <input type="text" name="level" value="guru" hidden>
                                                    <input type="text" name="status" value="active" hidden>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn bg-gradient-primary">Buat Akun</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <div class="d-flex justify-content-between">
                                <h6 class="text-white text-capitalize ps-3">Daftar Murid</h6>
                                <div class="dropdown pe-3">
                                    <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v text-white fw-bolder"></i>
                                    </a>
                                    <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">
                                        <li><a class="dropdown-item border-radius-md" data-bs-toggle="modal" data-bs-target="#tambahguru">Tambah Murid</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">NIS</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kelas</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tahun Masuk</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($murid as $mr)
                                    <tr>
                                        <td class="text-center">
                                            <div>
                                                @if(empty($mr->photo))
                                                @if($mr->jenis_kelamin == 'laki-laki')
                                                <img src="../assets/img/man.png" class="avatar avatar-sm me-3" alt="profile">
                                                @else
                                                <img src="../assets/img/woman.png" class="avatar avatar-sm me-3" alt="profile">
                                                @endif
                                                @else
                                                <img src="../assets/upload-img/{{$mr->photo}}" class="avatar avatar-sm me-3 border-radius-lg" alt="profile">
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{$mr->name}}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{$mr->email}}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{$mr->nis}}</p>
                                            <p class="text-xs text-secondary mb-0">{{$mr->jenis_kelamin}}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="text-secondary text-xs font-weight-bold">{{$mr->status_siswa}}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{$mr->tahun_masuk}}</span>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex">
                                                <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                                    <i class="material-icons opacity-10">edit</i>
                                                </a>
                                                <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                                    <i class="material-icons opacity-10">delete</i>
                                                </a>
                                                <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="material-icons opacity-10">more_horiz</i>
                                                </a>
                                                <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">
                                                    <!-- Create Account trigger modal -->
                                                    <li>
                                                        <a data-bs-toggle="modal" data-bs-target="#createaccountmodalsiswa{{$mr->id}}">Buat Akun</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="createaccountmodalsiswa{{$mr->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <form action="/createAccount" method="post">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Buat Akun</h5>
                                                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <span>Apakah anda yakin ingin membuatkan akun pada murid ini ? <span class="fw-bold">"{{$mr->name}}"</span></span>
                                                        <input type="email" name="email" value="{{$mr->email}}" hidden>
                                                        <input type="text" name="name" value="{{$mr->name}}" hidden>
                                                        <input type="text" name="siswa_id" value="{{$mr->id}}" hidden>
                                                        <input type="text" name="password" value="{{$mr->nis}}" hidden>
                                                        <input type="text" name="level" value="siswa" hidden>
                                                        <input type="text" name="status" value="active" hidden>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn bg-gradient-primary">Buat Akun</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <div class="d-flex justify-content-between">
                                <h6 class="text-white text-capitalize ps-3">Daftar Admin</h6>
                                <div class="dropdown pe-3">
                                    <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v text-white fw-bolder"></i>
                                    </a>
                                    <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">
                                        <li><a class="dropdown-item border-radius-md" data-bs-toggle="modal" data-bs-target="#tambahguru">Tambah Admin</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Pengguna</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Level Akun</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Dibuat Pada</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div>
                                                    <img src="../assets/img/team-2.jpg" class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">Admin Sekolah</h6>
                                                    <p class="text-xs text-secondary mb-0">admin@smp.ac.id</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">Admin</p>
                                            <p class="text-xs text-secondary mb-0">Super Admin</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">23/04/2023</span>
                                        </td>
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
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
