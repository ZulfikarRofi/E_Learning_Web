@extends('layout.master')
@section('page', 'Tambah Modul Baru')
@section('content')

<div class="col-lg-8 col-md-6 mb-md-0 mb-4">
    <div class="card">
        <div class="card-header pb-0">
            <div class="row">
                <div class="col-lg-6 col-7">
                    <h6>Tambah Modul Baru</h6>
                    <small>Masukkan data sesuai dengan formulir yang tertera</small>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="/storeAddModul/{{$id}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="input-group input-group-outline mb-3 mx-1">
                    <label class="form-label">Judul Modul</label>
                    <input type="text" class="form-control" name="judul" id="judul">
                </div>
                <div class="input-group input-group-outline mb-3 mx-1">
                    <label class="form-label">Nama Modul</label>
                    <input type="text" class="form-control" name="nama_modul" id="nama_modul">
                </div>
                <input type="date" name="tanggal_regis" id="tanggal_regis" hidden>
                <div class="row mb-3 ms-1" style="width: 100%">
                    <textarea name="deskripsi" id="basic-conf">Isi Modul</textarea>
                </div>
                <script>
                    tinymce.init({
                        selector: 'textarea#basic-conf',
                        width: 1200,
                        height: 500,
                        plugins: [
                            'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
                            'searchreplace', 'wordcount', 'visualblocks', 'code', 'fullscreen', 'insertdatetime', 'media',
                            'table', 'emoticons', 'template', 'help'
                        ],
                        toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | ' +
                            'bullist numlist outdent indent | link image | print preview media fullscreen | ' +
                            'forecolor backcolor emoticons | help',
                        menu: {
                            favs: {
                                title: 'My Favorites',
                                items: 'code visualaid | searchreplace | emoticons'
                            }
                        },
                        menubar: 'favs file edit view insert format tools table help',
                        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
                    });
                </script>

                <div class="text-end">
                    <button type="submit" class="btn btn-lg bg-gradient-primary btn-lg w-25 mt-2 mb-0">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
