<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-gray">
                    Form Tarik Data API :
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Rekening
                            <button data-paramt="rekening" class="badge badge-danger badge-pill btn-tarik-rekening">
                                Tarik Data
                            </button>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Lokasi
                            <button data-paramt="rekening" class="badge badge-danger badge-pill btn-tarik-lokasi">
                                Tarik Data
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">View Response</div>
                <div class="card-body">
                    <style>
                        .view-response {
                            background-color: lightblue;
                            max-height: 300px;
                            overflow: auto;
                        }
                    </style>
                    <div>
                        <h4> Response Data </h4>
                        <div class="overflow-auto">
                            <div class="view-response"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="loadMe" role="dialog" aria-labelledby="loadMeLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                Form Integrasi
                <button id="btnCloseModal" type="button" class="close" data-dismiss="modal" aria-label="Close"><i
                            class="fa fa-close"></i></button>
            </div>
            <div class="modal-body text-center">
                <div class="loader">
                    <img src="<?= base_url('assets/img/ajax-loader.gif'); ?>" class="img-responsive"/>
                </div>
                <div clas="loader-txt">
                    <p>Proses Integrasi <br><br><small>Mohon untuk tunggu sebentar</small></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->include('backend/javasc'); ?>
<script>
    $('.btn-tarik-rekening').click(function () {
        swalWithBootstrapButtons({
            title: `Apa anda yakin Menarik Data Rekening?`,
            text: "Silahkan Klik Tombol Tarik untuk melanjutkna Aksi ini.",
            type: 'info',
            showCancelButton: true,
            confirmButtonText: 'Tarik ',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: siteUrl('integrasi/referensi/input_rekening'),
                    type: 'POST',
                    dataType: 'JSON',
                    success: (response) => {
                        console.log(response)
                        notifSmartAlert(response.status, response.msg);
                        $('.view-response').html(`<pre>${JSON.stringify(response, undefined, 2)}</pre>`);
                    },
                    beforeSend: function () {
                        console.log('await');
                        $("#loadMe").modal({
                            backdrop: "static", //remove ability to close modal with click
                            keyboard: false, //remove option to close with keyboard
                            show: true //Display loader!
                        });
                    },
                    complete: function () {
                        console.log('Complete');
                        $('#loadMe').on('shown.bs.modal', function (e) {
                            $("#btnCloseModal").trigger("click");
                        })
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons(
                    'Cancel',
                    'Tidak ada aksi Posting data DPA',
                    'error'
                )
            }
        })
    })

    $('.btn-tarik-lokasi').click(function () {
        swalWithBootstrapButtons({
            title: `Apa anda yakin Menarik Data Lokasi?`,
            text: "Silahkan Klik Tombol Tarik untuk melanjutkna Aksi ini.",
            type: 'info',
            showCancelButton: true,
            confirmButtonText: 'Tarik ',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: siteUrl('integrasi/referensi/input_lokasi'),
                    type: 'POST',
                    dataType: 'JSON',
                    success: (response) => {
                        console.log(response)
                        // notifSmartAlert(response.status, response.msg);
                        $('.view-response').html(`<pre>${JSON.stringify(response, undefined, 2)}</pre>`);
                    },
                    beforeSend: function () {
                        console.log('await');
                        $("#loadMe").modal({
                            backdrop: "static", //remove ability to close modal with click
                            keyboard: false, //remove option to close with keyboard
                            show: true //Display loader!
                        });
                    },
                    complete: function () {
                        console.log('Complete');
                        $('#loadMe').on('shown.bs.modal', function (e) {
                            $("#btnCloseModal").trigger("click");
                        })
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons(
                    'Cancel',
                    'Tidak ada aksi Posting data DPA',
                    'error'
                )
            }
        })
    })


</script>
