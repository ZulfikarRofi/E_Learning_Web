@extends('layout.master')
@section('page', 'Konfigurasi Soal')
@section('content')

<div class="col-lg-8 col-md-6 mb-md-0 mb-4">
    <div class="card">

        <div class="card-header pb-0">
            <h6>Isi Soal</h6>
            <div class="row">
                @if($question)
                {!!$question->question_text!!}
                @else
                <p class="fw-bold text-danger">Soal Kosong, silahkan periksa kembali !</p>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h6>Daftar Opsi Soal</h6>
                <a href="/addOpsi/{{$question->id}}"><button class="btn btn-primary"> Tambah Opsi</button></a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th class="fw-bold text-xxl text-center" style="width: 10%;">No</th>
                        <th class="fw-bold text-xxl text-center" style="width: 70%;">Isi Opsi</th>
                        <th class="fw-bold text-xxl text-center" style="width: 20%;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($options as $o)
                    <tr>
                        <td class="text-xxl text-center"><a href="/detailSoal/{{$o->question_id}}">{{$loop->iteration}}</a></td>
                        <td class="text-xxl text-center" style="width: 700px">{{$o->option_text}}</td>
                        <td class="text-xxl text-center">
                            @if($o->status == true)
                            Benar
                            @else
                            Salah
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
