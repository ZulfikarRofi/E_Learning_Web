@extends('layout.masadmin')
@section('page', 'Detail Bot')
@section('content')

<div class="row mb-3 mx-1 vh-100">
    <div class="card">
        <div class="card-header pb-0">
            <div class="">
                <div class="d-flex justify-content-between">
                    <h6>Bot - {{$dataBot->nama_bot}} | {{$dataBot->nama_mapel}} Kelas {{$dataBot->nama_kelas}}</h6>
                    <div class="d-flex gap-3">
                        @if($listSiswa->isEmpty())
                        <button class="btn btn-danger pointer">Status Non Aktif</button>
                        @else
                        <span class="badge bg-success text-center text-xxs pb-0 pt-2 m-0">Status Aktif</span>
                        @endif
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Kelola Bot
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modaladdOption">Tambah Opsi</a></li>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modaladdAnswer">Tambah Jawaban</a></li>
                            </ul>
                        </div>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete-{{$dataBot->id}}"><i class="material-icons opacity-10 pt-2 ps-2">delete</i></a>
                    </div>
                </div>
                <p class="text-sm mb-0">
                    Konfigurasi Bot untuk chatbot siswa
                </p>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modaladdOption" tabindex="-1" aria-labelledby="modaladdOptionLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modaladdOptionLabel">Tambah Opsi</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/createOption/{{$dataBot->id}}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="input-group input-group-outline my-4">
                                <label class="form-label">Isi Opsi</label>
                                <input type="text" class="form-control" name="nama_kuis">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Add Answer -->
        <div class="modal fade" id="modaladdAnswer" tabindex="-1" aria-labelledby="modaladdAnswerLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content p-2">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modaladdOptionLabel">Tambah Jawaban</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/createAnswer/{{$dataBot->id}}" method="post">
                        @csrf
                        <div class="modal-body p-3">
                            <label for="option-target">Opsi Target</label>
                            <select class="form-select mb-3" id="option-target" aria-label="Default select example">
                                <option selected>--- Pilih target Opsi ---</option>
                                <option value="1">One</option>
                            </select>
                            <div class="input-group input-group-outline mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea class="form-control" style="width: 100%;" id="editor" name="description">Deskripsi Kuis</textarea>
                                <script>
                                    tinymce.init({
                                        selector: 'textarea#editor',
                                        plugins: 'code table list link image',
                                        toolbar: 'undo redo | format select | alignleft aligncenter alignright | link image | indent outdent | bullist numlist | code | table'
                                    });
                                </script>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal delete -->
        <div class="modal fade" id="modalDelete-{{$dataBot->id}}" tabindex="-1" role="dialog" aria-labelledby="modalDelete-{{$dataBot->id}}Label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-normal" id="exampleModalLabel">{{$dataBot->nama_bot}}</h5>
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin ingin menghapus bot ini <span class="fw-bold">"{{$dataBot->nama_bot}}"</span> ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Batal</button>
                        <form action="/deleteBot/{{$dataBot->id}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn bg-gradient-primary">Hapus Bot</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center text-capitalize">No</th>
                        <th class="text-center text-capitalize">Nama Siswa</th>
                        <th class="text-center text-capitalize">NIS</th>
                        <th class="text-center text-capitalize">Jenis Kelamin</th>
                        <th class="text-center text-capitalize">Kelas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listSiswa as $lS)
                    <tr>
                        <td class="text-sm text-center text-capitalize">{{$loop->iteration}}</td>
                        <td class="text-sm text-center text-capitalize">{{$lS->name}}</td>
                        <td class="text-sm text-center text-capitalize">{{$lS->nis}}</td>
                        <td class="text-sm text-center text-capitalize">{{$lS->jenis_kelamin}}</td>
                        <td class="text-sm text-center text-capitalize">{{$lS->nama_kelas}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection