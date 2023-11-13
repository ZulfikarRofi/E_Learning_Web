@extends('layout.masadmin')
@section('page', 'Isi Kuis')
@section('content')


<div class="col-lg-12 col-md-6 mb-md-0 mb-4">
    <div class="card">
        <div class="card-header pb-0">
            <div class="row">
                <div class="d-flex justify-content-between">
                    <h6>Tambah Kuis Baru</h6>
                </div>
            </div>
        </div>
        <div class="card-body">
            @php($a = 1)
            <div class="row">
                <div class="loopFormSoal" id="loopFormSoal"></div>
            </div>
            <form role="form">
                <div class="form-wrapper">
                @section('additionaljs')
                    <script id="loopSoal" type="text/x-handlebars-template">
                        <div class="hapusRowPerSoal row mb-2">
                            <h6 class="fw-bold">Soal <span class="" id="numberDisplay">1</span></h6>
                            <div class="rangkaian soal row mb-3 d-flex justify-content-center">
                                <div class="row mb-3">
                                    <input type="number" id="nomor_soal" value="" hidden>
                                    <textarea name="isiSoal[]" class="context-menu" style="width: 100rem; height:20px ">
                                        Soal
                                    </textarea>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="form-check d-flex gap-2 p-0 mb-3">
                                    <input class="form-check-input mt-3" type="radio" name="flexRadioDefault" id="optionRadio1">
                                    <div class="input-group input-group-outline mb-3" style="width: 85%;">
                                        <input type="text" class="form-control mt-1" placeholder="Opsi 1">
                                    </div>
                                    <div class="col-1 p-0" style="border: 0px;">
                                    <label class="input-group-text p-0 m-0" for="inputGroupFile02" style="border: 0px;">
                                        <img src="/assets/img/icons/png/picture-bw.png" style="width: 3rem" alt="upload">
                                    </label>
                                    <div class="input-group p-0 m-0">
                                        <input type="file" class="form-control" id="inputGroupFile02" style="width: 0%;" hidden>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="form-check d-flex gap-2 p-0 mb-3">
                                    <input class="form-check-input mt-3" type="radio" name="flexRadioDefault" id="optionRadio2">
                                    <div class="input-group input-group-outline mb-3" style="width: 85%;">
                                        <input type="text" class="form-control mt-1" placeholder="Opsi 2">
                                    </div>
                                    <div class="col-1 p-0" style="border: 0px;">
                                    <label class="input-group-text p-0 m-0" for="inputGroupFile02" style="border: 0px;">
                                        <img src="/assets/img/icons/png/picture-bw.png" style="width: 3rem" alt="upload">
                                    </label>
                                    <div class="input-group p-0 m-0">
                                        <input type="file" class="form-control" id="inputGroupFile02" style="width: 0%;" hidden>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="form-check d-flex gap-2 p-0 mb-3">
                                    <input class="form-check-input mt-3" type="radio" name="flexRadioDefault" id="optionRadio3">
                                    <div class="input-group input-group-outline mb-3" style="width: 85%;">
                                        <input type="text" class="form-control mt-1" placeholder="Opsi 3">
                                    </div>
                                    <div class="col-1 p-0" style="border: 0px;">
                                    <label class="input-group-text p-0 m-0" for="inputGroupFile02" style="border: 0px;">
                                        <img src="/assets/img/icons/png/picture-bw.png" style="width: 3rem" alt="upload">
                                    </label>
                                    <div class="input-group p-0 m-0">
                                        <input type="file" class="form-control" id="inputGroupFile02" style="width: 0%;" hidden>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="form-check d-flex gap-2 p-0 mb-3">
                                    <input class="form-check-input mt-3" type="radio" name="flexRadioDefault" id="optionRadio4">
                                    <div class="input-group input-group-outline mb-3" style="width: 85%;">
                                        <input type="text" class="form-control mt-1" placeholder="Opsi 4">
                                    </div>
                                    <div class="col-1 p-0" style="border: 0px;">
                                        <label class="input-group-text p-0 m-0" for="inputGroupFile02" style="border: 0px;">
                                            <img src="/assets/img/icons/png/picture-bw.png" style="width: 3rem" alt="upload">
                                        </label>
                                        <div class="input-group p-0 m-0">
                                            <input type="file" class="form-control" id="inputGroupFile02" style="width: 0%;" hidden>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </script>
                </div>
                {{-- </script> --}}

                <script>
                    //Looping Tampilan Soal
                    $(document).ready(function() {
                        var number = 0;
                        $(document).on('click', '#tambahSoal', function(e) {
                            e.preventDefault();
                            $(".formSoal").show();

                            number++;
                            // alert(number);

                            var isiSoal = $("#isiSoal").val();
                            var opsi1 = $("#opsi1").val();
                            var opsi2 = $("#opsi2").val();
                            var opsi3 = $("#opsi3").val();
                            var opsi4 = $("#opsi4").val();
                            var source = $("#loopSoal").html();
                            var source_replaced = source.replace('numberDisplay', 'numberDisplay' + number)
                            var template = Handlebars.compile(source_replaced);


                            var data = {
                                isiSoal: isiSoal,
                                opsi1: opsi1,
                                opsi2: opsi2,
                                opsi3: opsi3,
                                opsi4: opsi4,
                            }

                            var html = template(data);
                            $('#loopFormSoal').append(html);
                            $('#numberDisplay' + number).text(number);
                            // console.log(source);

                            tinymce.init({
                                selector: 'textarea',
                                height: 500,
                                plugins: [
                                    'link image imagetools table spellchecker lists'
                                ],
                                contextmenu: 'link image imagetools table spellchecker lists',
                                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
                            });
                        });
                        //hapus form
                        $(document).on('click', '.hapusSoal', function(event) {

                            $(this).closest('.hapusRowPerSoal').remove();
                            console.log('test');
                        });

                        //Submit Form
                        $(".submit").click(function() {

                            var nomor_soal = $('input[name="nomor_soal"]').val();
                            var isi_soal = $("input[name='isiSoal']").map(function(){
                                return this.value;
                            });
                            var opsi1 = $('input[name="opsi1"]').map(function(){
                                return this.value;
                            });
                            var opsi2 = $('input[name="opsi2"]').map(function(){
                                return this.value;
                            });
                            var opsi3 = $('input[name="opsi3"]').map(function(){
                                return this.value;
                            });
                            var opsi4 = $('input[name="opsi4"]').map(function(){
                                return this.value;
                            });
                            console.log(nomor_soal, isi_soal, opsi1, opsi2,opsi3,opsi4);
                            Swal.fire({
                            title: 'Do you want to save the changes?',
                            showDenyButton: true,
                            showCancelButton: true,
                            confirmButtonText: 'Save',
                            denyButtonText: `Don't save`,
                            }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                                if (result.isConfirmed) {
                                    Swal.fire('Saved!', '', 'success')
                                } else if (result.isDenied) {
                                    Swal.fire('Changes are not saved', '', 'info')
                                }
                            });
                        });




                        tinymce.init({
                            selector: 'textarea.context-menu',
                            height: 500,
                            plugins: [
                                'link image imagetools table spellchecker lists'
                            ],
                            contextmenu: 'link image imagetools table spellchecker lists',
                            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
                        });
                    });
                </script>
                @endsection
                <div class="text-end">
                    <button type="button" class="hapusSoal btn btn-outline-danger mt-4 me-2" id="hapusSoal" onclick="">Hapus Soal</button>
                    <button type="button" class="tambahSoal btn btn-secondary mt-4 me-2" id="tambahSoal" onclick="">Tambah Soal</button>
                    <input type="submit" class="btn btn-lg bg-gradient-primary btn-lg w-25 mt-2 mb-0 submit" value="Submit"/>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
