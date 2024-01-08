@extends('layout.master')
@section('page', 'Kuis')
@section('content')

<div class="col-lg-8 col-md-6 mb-md-0 mb-4">
    <div class="card">
        <div class="card-header pb-0">
            <div class="row">
                <div class="d-flex justify-content-between">
                    <div class="judul">
                        <h4>{{$allKuis->nama_kuis}}</h4>
                        <p>Kelas {{$allKuis->nama_kelas}}</p>
                    </div>
                    <div class="dropdown float-lg-end pe-4">
                        <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown" id="navbarDropdownMenuLink2">
                            <i class="fa fa-ellipsis-v text-secondary"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink2">
                            <li><a class="dropdown-item border-radius-md" href="/configQuiz/{{$allKuis->id}}">Edit Kuis</a></li>
                            <li><a class="dropdown-item border-radius-md" data-bs-toggle="modal" data-bs-target="#hapusKuis">Hapus Kuis</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-7">
                    <ul class="ps-0">
                        <li style="list-style: none;">Subjek : <span class="fw-bold" style="text-transform: caoitalize;">{{$allKuis->nama_mapel}}</span> </li>
                        <li style="list-style: none;">Waktu Pengerjaan : <span class="fw-bold" style="text-transform: capitalize;">0 Menit</span></li>
                        <li style="list-style: none;">Total Soal : <span class="fw-bold" style="text-transform: capitalize;">{{$totalSoal}} Soal</span></li>
                        <li style="list-style: none;">Jam Pengerjaan : <span class="fw-bold text-primary" style="text-transform: capitalize;">{{$allKuis->duedate}}</span></li>
                    </ul>
                </div>
                <div class="col-5 d-flex flex-column justify-content-between align-items-end">
                    <p class="fw-semibold">Status : <span class="fw-bold badge bg-gradient-secondary">Belum Diset</span></p>
                    <p style="font-size: 14px;" class="text-secondary fw-semibold"><a href="/detail/hasil/{{$reportId->id}}">Lihat Hasil...</a></p>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="hapusKuis" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Hapus Kuis</h5>
                            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Yakin anda ingin menghapus Kuis ini "<span class="fw-bolder">{{$allKuis->nama_kuis}}</span>"
                        </div>
                        <div class="modal-footer">
                            <form action="/hapuskuis/{{$allKuis->id}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn bg-gradient-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
