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
        <form action="/storeSoal" method="post">
            @csrf
            <div class="row mb-3">
                <div class="col-12">
                    <div class="row mb-3 ms-1" style="width: 100%">
                        <textarea name="isiSoal" id="basic-conf">Isi Soal</textarea>
                    </div>
                    <input type="number" value="{{$kuis->id}}" name="kuis_id" hidden>
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
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class=" btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>

@endsection
