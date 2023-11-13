@extends('layout.masadmin')
@section('page', 'Manajemen Pelajaran')
@section('content')

<div class="container-fluid py-4">
    <div class="row mb-3">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between">
                        <h6 class="text-white text-capitalize ps-3">Daftar Mata Pelajaran</h6>
                        <a class="cursor-pointer px-4" id="dropdownTable" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-ellipsis-v text-white"></i>
                        </a>
                        <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">
                            <li><a class="dropdown-item border-radius-md" data-bs-toggle="modal" data-bs-target="#tambahMapel">Tambah Mata Pelajaran</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Mata Pelajaran</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ps-2 opacity-7">Kelas</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ps-2 opacity-7">ID Mata Pelajaran</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jadwal</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Guru Pengampu</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($i = 1)
                                @foreach($dataMapel as $mp)
                                <tr>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{$i++}}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-sm font-weight-bold text-capitalize"><a href="/detail/matapelajaran/{{$mp->id}}">{{$mp->nama_mapel}}</a></span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-sm font-weight-bold text-capitalize"><a href="/detail/matapelajaran/{{$mp->id}}">{{$mp->nama_kelas}}</a></span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <p class="text-xs font-weight-bold text-capitalize mb-0"><a href="/detail/matapelajaran/{{$mp->id}}">{{$mp->mapel_id}}</a></p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold text-capitalize"><a href="/detail/matapelajaran/{{$mp->id}}">
                                                {{$mp->hari_pelajaran}},
                                                @foreach(json_decode($mp->jam_pelajaran) as $value)
                                                {{$value}}
                                                @endforeach
                                            </a>
                                        </span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold text-capitalize">
                                            <div class="avatar-group mt-2">
                                                @if(empty($mp->photo))
                                                <a href="" class="avatar avatar-sm" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{$mp->nama_guru}}">
                                                    @if($mp->jenis_kelamin == 'perempuan')
                                                    <img src="../assets/img/woman.png" class="border-radius-lg" alt="team1">
                                                    @else
                                                    <img src="../assets/img/man.png" class="border-radius-lg" alt="team1">
                                                    @endif
                                                </a>
                                                @else
                                                <a href="" class="avatar avatar-sm" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{$mp->nama_guru}}">
                                                    <img src="/../photo/{{$mp->photo}}" class="border-radius-lg" alt="team2">
                                                </a>
                                                @endif
                                            </div>
                                        </span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold text-capitalize">{{$mp->status}}</span>
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
                                @endforeach
                            </tbody>
                        </table>

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
                                    <form action="/storeMapel" method="post">
                                        <div class="modal-body">
                                            @csrf
                                            <div class="input-group input-group-outline mb-3">
                                                <label for="" class="form-label">Nama Mata Pelajaran</label>
                                                <input type="text" class="form-control" name="nama_mapel" id="nama_mapel">
                                            </div>
                                            <div class="input-group input-group-outline mb-3">
                                                <label for="" class="form-label">Deskripsi Singkat</label>
                                                <input type="text" class="form-control" name="deskripsi" id="deskripsi">
                                            </div>
                                            <div class="mb-3">
                                                <select name="guru_id" id="guru_id" class="form-select ps-2 text-capitalize text-secondary text-sm font-weight-normal">
                                                    <option value="" class="text-center">--- Pilih Guru Pengampu ---</option>
                                                    @foreach($guru as $gr)
                                                    <option value="{{$gr->id}}" class="text-capitalize text-secondary text-sm font-weight-bold">{{$gr->nama_guru}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <select name="kelas_id" id="kelas_id" class="form-select ps-2 text-capitalize text-secondary text-sm font-weight-normal">
                                                    <option value="" class="text-center">--- Pilih Kelas Tujuan ---</option>
                                                    @foreach($kelas as $kl)
                                                    @if($kl->id !== 1)
                                                    <option value="{{$kl->id}}" class="text-capitalize text-secondary text-sm font-weight-bold">{{$kl->nama_kelas}}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <select name="hari_pelajaran" id="hari_pelajaran" class="form-select ps-2 text-capitalize text-secondary text-sm font-weight-normal">
                                                    <option value="" class="text-center">--- Pilih Hari Pelajaran ---</option>
                                                    <option value="senin" class="text-center">Senin</option>
                                                    <option value="selasa" class="text-center">Selasa</option>
                                                    <option value="rabu" class="text-center">Rabu</option>
                                                    <option value="kamis" class="text-center">Kamis</option>
                                                    <option value="jumat" class="text-center">Jumat</option>
                                                </select>
                                            </div>
                                            <label for="" class="form-label">Jam Pelajaran</label>
                                            <div class="d-flex mb-3 px-3">
                                                <input type="time" class="form-control px-5 border-1" name="jam_masuk" id="jam_masuk">
                                                <input type="time" class="form-control ms-2 px-5" name="jam_selesai" id="jam_selesai">
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
            </div>
        </div>
    </div>
    <!-- Daftar Periode dan Mata Pelajaran -->
    <div class="row">
        <div class="col-6">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between">
                        <h6 class="text-white text-capitalize ps-3">Daftar Periode</h6>
                        <a class="cursor-pointer px-4" id="dropdownTable" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-ellipsis-v text-white"></i>
                        </a>
                        <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">
                            <li><a class="dropdown-item border-radius-md" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Tambah Periode</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <!-- Modal -->
                    <div class="modal fade" id="staticBackdrop" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Periode Baru</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="/addPeriod" method="post">
                                        @csrf
                                        <label for="" class="form-label">Tanggal Mulai</label>
                                        <div class="input-group input-group-outline mb-3">
                                            <label for="form-label"></label>
                                            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai">
                                        </div>
                                        <label for="" class="form-label">Tanggal Berakhir</label>
                                        <div class="input-group input-group-outline mb-3">
                                            <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir">
                                        </div>
                                        <select class="form-select p-2" name="tipe" id="tipe">
                                            <option value="" selected>--- Pilih Tipe Tahun Ajaran ---</option>
                                            <option value="ganjil">Ganjil</option>
                                            <option value="genap">Genap</option>
                                        </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Tambahkan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-center text-xxs font-weight-bolder opacity-7">Tahun Ajaran</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tipe</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Aktif</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($i = 1)
                                @foreach($period as $p)
                                <tr>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{$p->tahun_ajaran}}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-capitalize text-xs font-weight-bold">{{$p->tipe}}</span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-secondary text-xs font-weight-bold">{{$p->tanggal_mulai}} s/d {{$p->tanggal_akhir}}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        @if($p->status == 'aktif')
                                        <span class="badge bg-success text-xs font-weight-bold" style="text-transform: capitalize;">{{$p->status}}</span>
                                        @elseif($p->status == 'berakhir')
                                        <span class="badge bg-danger text-xs font-weight-bold" style="text-transform: capitalize;">{{$p->status}}</span>
                                        @else
                                        <span class="badge bg-secondary text-xs font-weight-bold" style="text-transform: capitalize;">{{$p->status}}</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex">
                                            <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-bs-toggle="modal" data-bs-target="#editStatus-{{$p->id}}">
                                                <i class="material-icons opacity-10">settings</i>
                                            </a>
                                            <!-- Modal -->
                                            <div class="modal fade" id="editStatus-{{$p->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Periode {{$p->tahun_ajaran}}</h5>
                                                            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="/editStatus/{{$p->id}}" method="post">
                                                                @csrf
                                                                @method('PATCH')
                                                                <label for="">Status</label>
                                                                <select class="form-select" name="status" id="status">
                                                                    <option value="">--- Pilih Status Periode Saat ini ---</option>
                                                                    <option value="aktif">Aktif</option>
                                                                    <option value="berakhir">Berakhir</option>
                                                                </select>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn bg-gradient-primary">Simpan</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
        </div>
        <div class="col-6">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between">
                        <h6 class="text-white text-capitalize ps-3">Daftar Kelas</h6>
                        <a class="cursor-pointer px-4" id="dropdownTable" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-ellipsis-v text-white"></i>
                        </a>
                        <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">
                            <li><a class="dropdown-item border-radius-md" data-bs-toggle="modal" data-bs-target="#tambahKelas">Tambah Kelas</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <!-- Modal -->
                    <div class="modal fade" id="tambahKelas" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Kelas Baru</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="/addKelas" method="post">
                                        @csrf
                                        <div class="input-group input-group-outline mb-3">
                                            <label for="" class="form-label">Nama Kelas</label>
                                            <input type="text" class="form-control" id="nama_kelas" name="nama_kelas">
                                        </div>
                                        <select class="form-select p-2 text-capitalize" name="periode_id" id="periode_id">
                                            <option value="" selected>--- Pilih Periode Tahun Ajaran ---</option>
                                            @foreach($period as $p)
                                            <option value="{{$p->id}}" class="text-capitalize">{{$p->tahun_ajaran}} {{$p->tipe}}</option>
                                            @endforeach
                                        </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Tambahkan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-center text-xxs font-weight-bolder opacity-7">Nama Kelas</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tahun Ajaran</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Semester</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($i = 1)
                                @foreach($kelas as $k)
                                <tr>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-capitalize text-xs font-weight-bold"><a href="/detail/kelas/{{$k->id}}">{{$k->nama_kelas}}</a></span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-capitalize text-xs font-weight-bold"><a href="/detail/kelas/{{$k->id}}">{{$k->tahun_ajaran}}</a></span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-capitalize text-xs font-weight-bold"><a href="/detail/kelas/{{$k->id}}">{{$k->tipe}}</a></span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-capitalize text-xs font-weight-bold"><a href="/detail/kelas/{{$k->id}}">{{$k->status}}</a></span>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex">
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
        </div>
    </div>
</div>

@endsection
