<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card card-outline">
                <?= form_open($moduleUrl . '/input_data', ['class' => 'form-bukti']); ?>
                <div class="card-header">
                    Bukti Kelengkapan Pengadaan
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label>Uraian Bukti Pengadaan</label>
                            <input type="text"
                                   class="form-control <?= ($validation->hasError('uraian')) ? 'is-invalid' : ''; ?> uraian"
                                   placeholder="Uraian Bukti" name="uraian" value="<?= old('uraian'); ?>" required>
                            <div class="invalid-feedback">
                                <?= $validation->getError('uraian'); ?>
                            </div>
                        </div>
                    </div>
                    <!--                    <div class="form-group row">-->
                    <!--                        <div class="col-auto text-center">-->
                    <!--                            <div class="form-check">-->
                    <!--                                <input class="form-check-input status-parent" type="checkbox" id="status_parent">-->
                    <!--                            </div>-->
                    <!--                        </div>-->
                    <!--                        <div class="col-auto">-->
                    <!--                            <label class="form-check-label" for="status_parent">-->
                    <!--                                Status Parent-->
                    <!--                            </label>-->
                    <!--                        </div>-->
                    <!--                        <div class="col-md-12">-->
                    <!--                            <div class="view-parent"></div>-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                    <div class="form-group row">
                        <div class="col-auto text-center">
                            <div class="form-check">
                                <input class="form-check-input status-input" type="checkbox"
                                       name="status_input" id="status_input">
                            </div>
                        </div>
                        <div class="col-auto">
                            <label class="form-check-label" for="status_input">
                                Fixed
                            </label>
                        </div>
                    </div>
                    <?= getCsrf(); ?>
<!--                    <note>-->
<!--                        Keterangan-->
<!--                        <ul>-->
<!--                            <li>Centang Status input untuk data Parent dan melakukan Input data</li>-->
<!--                        </ul>-->
<!--                    </note>-->
                </div>
                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
                    <button type="button" class="btn btn-danger btn-flat" onclick="window.location.reload()"><i
                                class="fa fa-power-off"></i> Reset
                    </button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card card-outline">
                <div class="card-header">
                    Bukti Kelengkapan Pengadaan
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-sm  table-bordered tabel_3" style="width: 100%">
                                <thead>
                                <tr>
                                    <th width="8%">No</th>
                                    <th>Uraian</th>
                                    <th>Input</th>
                                    <th><i class="fa fa-cog"></i></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $no = 1;
                                foreach ($getBuktiPengadaan as $row) {
                                    if ($row['parent'] == 0) {
                                        ?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td><?= $row['uraian']; ?></td>
                                            <td class="text-center">
                                                <?php
                                                if ($row['status_input'] == 0) {
                                                    $attrTmbh = " data-parent='{$row['id_bukti']}'";
                                                    echo btn_tambah($attrTmbh, ' Client', ' btn-xs btn-block btn-client');
                                                }else{
                                                    echo '[Nilai Input]';
                                                } ?>
                                            </td>
                                            <td class="text-center">
                                                <?php
                                                $attrHps = " data-id_bukti='{$row['id_bukti']}'
                                                         data-uraian='{$row['uraian']}'";
                                                echo btn_hapus($attrHps, '', ' btn-xs btn-hapus');
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                        $no_c = 1;
                                        foreach ($getBuktiPengadaan as $client) {
                                            if ($client['parent'] == $row['id_bukti'] and $client['parent'] != 0) { ?>
                                                <tr>
                                                    <td><?= $no.'.'.$no_c; ?></td>
                                                    <td><?= $client['uraian']; ?></td>
                                                    <td class="text-center">[Nilai Input]</td>
                                                    <td class="text-center">
                                                        <?php
                                                        $attrHps = " data-id_bukti='{$client['id_bukti']}'
                                                         data-uraian='{$client['uraian']}'";
                                                        echo btn_hapus($attrHps, '', ' btn-xs btn-hapus');
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php
                                                $no_c++;
                                            }
                                        }
                                        $no++;
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->include('backend/javasc'); ?>
<div class="modal fade" id="modal-client" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?= form_open(site_url($moduleUrl . '/input_data'), ['class' => 'form-client']) ?>
            <form class="form-upload" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title label_head"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row form-group">
                        <div class="col-md-12">
                            <label>Uraian</label>
                            <textarea class="form-control uraian" name="uraian"></textarea>
                        </div>
                    </div>
                    <input type="hidden" class="form-control parent" name="parent">
                    <input type="hidden" class="form-control status_input" name="status_input" value="1">
                    <input type="hidden" class="form-control id_bukti" name="id_bukti">
                    <?= getCsrf(); ?>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success"><i class="fa fa-power-off"></i> Simpan</button>
                </div>
                <?= form_close(); ?>
        </div>
    </div>
</div>
<script>
    $(document).on('click', '.status-parent', function () {
        if ($(this).is(':checked')) {
            $.getJSON(siteUrl('<?=$moduleUrl;?>/load_bukti_pengadaan'), function (dataLoad) {
                let htmls = `<select class="form-control select2bs4" name="parent" required style="width: 100%">
                                <option selected disabled value="">.: Pilih Parent :.</option>`;
                dataLoad.forEach((res) => {
                    htmls += `<option value="${res.id_bukti}">${res.uraian}</option>`;
                })
                htmls += `</select>`;
                $('.view-parent').html(htmls);
            })
        } else {
            $('.view-parent').html('');
        }
    })

    $('.btn-client').click(function (e) {
        e.preventDefault();
        const parent = $(this).data('parent');
        const thisTag = $('#modal-client')
        console.log(parent)
        thisTag.modal('show')
        thisTag.find('.modal-title').text('Form Input Client');
        thisTag.find('.parent').val(parent);
    })
    $('.btn-hapus').click(function () {
        const id_bukti = $(this).data('id_bukti')
        const uraian = $(this).data('uraian')
        const token = $('#token').val()
        console.log(token)
        swalWithBootstrapButtons({
            title: `Apa anda yakin Menghapus Bukti Pengadaan : ${uraian}`,
            text: "Silahkan Klik Tombol Delete Untuk melakukan Aksi",
            type: 'info',
            showCancelButton: true,
            confirmButtonText: 'Delete ',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?= site_url($moduleUrl . '/delete_data'); ?>",
                    dataType: 'json',
                    data: {id_bukti, token},
                    success: (res) => {
                        notifSmartAlert(res.status, res.ket)
                    },
                    error: (request, status, error) => {
                        notifSmartAlert(false, request.responseText);
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons(
                    'Cancel',
                    'Tidak ada aksi hapus data',
                    'error'
                )
            }
        })
    })

    // loadParent()
    function loadParent() {
        $.getJSON(siteUrl('<?=$moduleUrl;?>/load_bukti_pengadaan'), function (res) {
            console.log(res);
        })
    }
</script>