@extends('layout.master')
@section('page', 'Tambah Kuis Baru')
@section('content')

<div class="col-lg-8 col-md-6 mb-md-0 mb-4">
    <div class="card">
        <div class="card-header pb-0">
            <div class="row">
                <div class="col-lg-6 col-7">
                    <h6>Tambah Kuis Baru</h6>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="/storeAddQuiz/{{$id}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <div class="col-7">
                        <div class="input-group input-group-outline my-4">
                            <label class="form-label">Judul</label>
                            <input type="text" class="form-control" name="nama_kuis">
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="input-group input-group-static">
                            <label for="">Batas Waktu</label>
                            <input type="datetime-local" class="form-control" name="duedate">
                        </div>
                    </div>
                </div>
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
                <div class="text-end">
                    <button type="submit" class="btn btn-lg bg-gradient-primary btn-lg w-25 mt-2 mb-0">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection