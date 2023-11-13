@extends('layout.masteradmin')
@section('page', 'Chatbot')
@section('content')

<div class="row mb-3 mx-1">
    <div class="card">
        <div class="card-header pb-0">
            <div class="col-lg-6 col-7">
                <h6>Tambahkan Bot Baru</h6>
                <p class="text-sm mb-0">
                    membuat bot materi untuk diakses siswa dengan mata pelajaran terkait
                </p>
            </div>
        </div>
        <div class="card-body">
            <form action="/storeBot" method="post">
                @csrf
                <div class="input-group input-group-dynamic mb-4">
                    <span class="input-group-text" id="basic-addon2">Bot</span>
                    <input type="text" name="nama_bot" class="form-control" placeholder="Masukkan nama bot baru!" aria-label="Recipient's username" aria-describedby="basic-addon2">
                </div>
                <div class="input-group input-group-static mb-4">
                    <select class="form-control" id="" name="id_kelasMapel">
                      <option>--- pilih mata pelajaran target ---</option>
                      @foreach ($data as $datas)
                        <option class="" value="[{{$datas->idMapel}}, {{$datas->idKelas}}]">{{$datas->nama_mapel}} Kelas {{$datas->nama_kelas}}</option>
                      @endforeach
                    </select>
                </div>

                {{-- <div class="input-group input-group-outline mb-3">
                    <div class="selection-box p-2">
                        <ul class="d-flex m-0 p-0">
                            <li class="m-1 d-flex align-items-center"><span class="fw-bold">Kelas IX-A</span><i class="material-icons opacity-10" style="font-size: 12px">close</i></li>
                            <li class="m-1 d-flex align-items-center"><span class="fw-bold">Kelas IX-B</span><i class="material-icons opacity-10" style="font-size: 12px">close</i></li>
                            <li class="m-1 d-flex align-items-center"><span class="fw-bold">Kelas IX-C</span><i class="material-icons opacity-10" style="font-size: 12px">close</i></li>
                            <li class="m-1 d-flex align-items-center"><span class="fw-bold">Kelas IX-D</span><i class="material-icons opacity-10" style="font-size: 12px">close</i></li>
                            <input type="text" id="addSelect">
                        </ul>
                    </div>
                </div> --}}
                <button type="submit" class="btn btn-primary">Buat Bot Baru</button>
            </form>
        </div>
    </div>
</div>
<div class="row mt-3">
    @foreach ($dataBot as $db)
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                   <a href="/detail/chatbot/{{$db['bot_id']}}"><i class="material-icons opacity-10">smart_toy</i></a>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize pointer" data-bs-toggle="modal" data-bs-target="#exampleModal-{{$db['bot_id']}}">Bot - {{$db['nama_bot']}}</p>
                    <h4 class="mb-0">{{$db['total_data']}} Data</h4>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
                @if ($db['last_update'] == 0)
                    <p class="mb-0"><i class="fa fa-clock me-1"></i>Last update: Today</p>
                @elseif ($db['last_update'] == 1)
                    <p class="mb-0"><i class="fa fa-clock me-1"></i>Last update: Yesterday</p>
                @else
                    <p class="mb-0"><i class="fa fa-clock me-1"></i>Last update: {{$db['last_update']}} Days ago</p>
                @endif

            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal-{{$db['bot_id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="/storeListChatbot" method="post">
                    @csrf
                    <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-sm">Apakah anda yakin ingin mengaktifkan chatbot ini "<span class="fw-bold text-primary">{{$db['nama_bot']}}</span>" ?</p>
                        <input type="number" value="{{$db['kelas_id']}}" name="kelas_id" hidden>
                        <input type="number" value="{{$db['bot_id']}}" name="bot_id" hidden>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn bg-gradient-primary">Ya</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>


@endsection
