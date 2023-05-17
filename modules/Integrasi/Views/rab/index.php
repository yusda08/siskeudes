<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"><h4><?= $row_kec['nama_kecamatan']; ?></h4>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-gray">
                    Form Tarik Data API :
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Data Bidang
                            <button data-kd_kec="<?= $row_kec['kd_kec']; ?>" data-paramt="perencanaan"
                                    class="badge badge-danger badge-pill btn-tarik-data">Tarik
                                Data
                            </button>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Data APBDes
                            <button data-kd_kec="<?= $row_kec['kd_kec']; ?>" data-paramt="rab"
                                    class="badge badge-danger badge-pill btn-tarik-data">Tarik
                                Data
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
                <div class="status-integrasi"></div>
                <div class="btn-close"></div>
                <div clas="loader-txt">
                    <p>Proses Integrasi <br><br><small>Mohon untuk tunggu sebentar</small></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->include('backend/javasc'); ?>
<script>
    $('.btn-tarik-data').click(function () {
        const kd_kec = $(this).data('kd_kec');
        const paramt = $(this).data('paramt');
        const url = paramt == 'rab' ? siteUrl('integrasi/rab/input_rab') : siteUrl('integrasi/rab/input_perencanaan');
        swalWithBootstrapButtons({
            title: `Apa anda yakin Menarik Data Rab ?`,
            text: "Silahkan Klik Tombol Tarik untuk melanjutkna Aksi ini.",
            type: 'info',
            showCancelButton: true,
            confirmButtonText: 'Tarik ',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'JSON',
                    data: {kd_kec: kd_kec},
                    success: (response) => {
                        console.log(response)
                        // notifSmartAlert(response.status, response.ket);
                        $('.view-response').html(`<pre>${JSON.stringify(response, undefined, 2)}</pre>`);
                    },
                    beforeSend: function () {
                        console.log('await');
                        $("#loadMe").modal({
                            backdrop: "static", //remove ability to close modal with click
                            keyboard: false, //remove option to close with keyboard
                            show: true //Display loader!
                        });
                        $('.status-integrasi').html(`<h4><i class="fas fa-circle-notch fa-spin"></i> Waiting...</h4>`)
                    },
                    complete: function () {
                        $('#loadMe').on('shown.bs.modal', function (e) {
                            $("#btnCloseModal").trigger("click");
                        })
                        $('.status-integrasi').html(`<h4><i class="fas fa-check"></i> Selesai</h4>
                                                    <br><button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"><i class="fas fa-remove"></i> Close</button>`)
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

    //$('.btn-cek-api').click(function () {
    //    var api_key = $('.api_key').val();
    //    $.ajax({
    //        type: 'GET',
    //        url: '<?//= site_url('data_kendaraan/get_kendaraan'); ?>//',
    //        dataType: 'json',
    //        data: {api_key: api_key},
    //        success: function (data) {
    //            $('#data_json').html(JSON.stringify(data, undefined, 2));
    //        }
    //    });
    //});

    //    document.getElementById("data_json").innerHTML = ;
</script>
