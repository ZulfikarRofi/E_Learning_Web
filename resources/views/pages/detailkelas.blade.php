@extends('layout.masteradmin')
@section('page', 'Kelas')
@section('content')

<div class="container">
    @foreach($data as $d)
    <div class="row">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Detail Kelas</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">

                <div class="ps-4 row ">
                    <div class="d-flex justify-content-between">
                        <div class="">
                            <p class="fw-bold text-lg card-title my-0 py-0" style="color:black">Kelas - {{$d->nama_kelas}}</p>
                            <p class="passive-text fw-normal my-0 py-0">{{$d->tahun_ajaran}}</p>
                        </div>
                        <div class="d-flex align-items-center px-4">
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahPeserta">
                                <i class="material-icons opacity-10 fs-6">
                                    person_add
                                </i>
                                Tambah Peserta Kelas
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row my-5">
                    <!-- Modal -->
                    <div class="modal fade" id="tambahPeserta" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Peserta Kelas</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3 d-flex align-items-center">
                                        <div class="input-group input-group-outline" style="width: 90%;">
                                            <label class="form-label">Cari siswa...</label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <button type="submit" class="btn btn-outline-primary mt-3 ms-2" style="width: 10%;">
                                            <span class="material-icons">search</span>
                                        </button>
                                    </div>
                                    <form action="/updateKelas" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <div class="table-responsive p-0">
                                            <table class="table align-items-center mb-0">
                                                <thead>
                                                    <tr>
                                                        <th class="text-secondary text-left">
                                                            <span class="form-check ps-4 text-secondary text-center text-xxs font-weight-bolder" style="width:100%">Pilih Semua</span>
                                                            <div class="form-check text-center">
                                                                <input class="form-check-input" type="checkbox" value="" id="select-all" name="select-all">
                                                            </div>
                                                        </th>
                                                        <th class=" text-uppercase text-secondary text-center text-sm font-weight-bolder opacity-7">Nama Siswa
                                                        </th>
                                                        <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">NIS</th>
                                                        <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Jenis Kelamin</th>
                                                        <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($notParticipate as $np)
                                                    <tr>
                                                        <td class="align-middle text-center">
                                                            <div class="form-check">
                                                                <input type="hidden" name="kelas" value="{{$d->id}}">
                                                                <input class="form-check-input checkbox-item" type="checkbox" value="{{$np->id}}" name="siswa[]">
                                                            </div>
                                                        </td>
                                                        <td class="align-middle text-center">
                                                            <span class="text-secondary text-capitalize text-sm font-weight-bold">{{$np->name}}</span>
                                                        </td>
                                                        <td class="align-middle text-center">
                                                            <span class="text-secondary text-capitalize text-sm font-weight-bold">{{$np->nis}}</span>
                                                        </td>
                                                        <td class="align-middle text-center">
                                                            <span class="text-secondary text-capitalize text-sm font-weight-bold">{{$np->jenis_kelamin}}</span>
                                                        </td>
                                                        <td class="align-middle text-center">
                                                            <span class="text-secondary text-capitalize text-sm font-weight-bold">{{$np->status_siswa}}</span>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                </div>
                                <div class="modal-footer p-2">
                                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn bg-gradient-primary">Simpan Perubahan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-center text-sm font-weight-bolder opacity-7">#</th>
                                    <th class="text-uppercase text-secondary text-center text-sm font-weight-bolder opacity-7">Foto Siswa</th>
                                    <th class="text-uppercase text-secondary text-center text-sm font-weight-bolder opacity-7">Nama Siswa</th>
                                    <th class="text-uppercase text-secondary text-center text-sm font-weight-bolder opacity-7">NIS</th>
                                    <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Angkatan</th>
                                    <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Jenis Kelamin</th>
                                    <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Status</th>
                                    <th class="text-uppercase text-secondary text-center text-sm font-weight-bolder opacity-7"></th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($a = 1)
                                @foreach($classParticipate as $cp)
                                <tr>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-capitalize text-sm font-weight-bold">{{$a++}}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <img src="" alt="">
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-capitalize text-sm font-weight-bold">{{$cp->name}}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-capitalize text-sm font-weight-bold">{{$cp->nis}}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-capitalize text-sm font-weight-bold">{{$cp->tahun_masuk}}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-capitalize text-sm font-weight-bold">{{$cp->jenis_kelamin}}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-capitalize text-sm font-weight-bold">{{$cp->status_siswa}}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <a class="cursor-pointer" data-bs-toggle="modal" data-bs-target="#deleteSiswa-{{$cp->id}}"><i class="material-icons">delete</i></a>
                                        <!-- Modal -->
                                        <div class="modal fade" id="deleteSiswa-{{$cp->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Keluarkan Siswa Dari Kelas</h5>
                                                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Keluarkan Siswa <span class="text-capitalize font-weight-bold">{{$cp->name}}</span> dari kelas <span class="text-capitalize font-weight-bold">{{$d->nama_kelas}}</span>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="/kickOut/{{$cp->id}}" method="post">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn bg-gradient-primary">Simpan</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <ul class="pagination pagination-primary">
                    <li class="page-item active">
                        <a class="page-link" href="javascript:;">1</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#link">2</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#link">3</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#link">4</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#link">5</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#link">6</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#link">7</a>
                    </li>
                </ul>
            </div>
            <script>
                $(document).ready(function() {
                    $('#select-all').change(function() {
                        if ($(this).is(':checked')) {
                            console.log('asd');
                            $('.checkbox-item').prop('checked', true);
                        } else {
                            $('.checkbox-item').prop('checked', false);
                        }
                    });

                    //individual checkbox change event
                    $('.checkbox-item').change(function() {
                        console.log($(this).val());
                    })
                });
            </script>
        </div>
    </div>
    @endforeach
</div>

@endsection