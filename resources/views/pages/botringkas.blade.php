@extends('layout.masteradmin')
@section('page', 'Halaman Admin')
@section('content')

<div class="card py-3">
    <div class="card-title ms-3">
        <div class="content-header d-flex justify-content-between">
            <h5 class="fw-bold">Daftar Data Kalimat Ringkasan</h5>
            <p class="fw-semibold text-secondary">Tahapan : Input Kalimat </p>
        </div>
    </div>
    <div class="card-body">
        @foreach ($dataRingkasan as $dr)
            <p class="fw-semibold m-0 p-0">{{$dr['data']}}</p>

        @endforeach

        <h6>Ini hasil tokenisasi</h6>
        @foreach ($resultToken as $rT)
            <p class="text-xxs m-0 p-0">{{$rT['data']}}</p>
        @endforeach
    </div>
</div>



@endsection
