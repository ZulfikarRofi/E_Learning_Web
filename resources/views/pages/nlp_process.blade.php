@extends('layout.master')
@section('page', 'Tambah Soal Kuis')
@section('content')


<div class="card col-8">

    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card-header pb-0">
        <div class="row">
            <div class="d-flex justify-content-between">
                <h6>Tambah Soal Baru</h6>
            </div>
        </div>
    </div>
    <div class="card-body">
        <h1>Processed Text:</h1>
        <p>{{ $processedText }}</p>

        <h2>Top Words and Weights:</h2>
        <ul>
            @foreach($topWordsWithWeights as $word => $weight)
            <li>Word: {{ $word }} - Weight: {{ $weight }}</li>
            @endforeach
        </ul>
        <form action="/storeNLP" method="post">
            @csrf
            <div class="row mb-3">
                <div class="col-12">
                    <div class="input-group input-group-outline">
                        <label class="form-label">Isi Text</label>
                        <input type="text" class="form-control" name="text">
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class=" btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>

@endsection