<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card card-outline">
                <?= form_open($moduleUrl . '/input_data', ['class' => 'form-bukti']); ?>
                <div class="card-header">
                    Bukti Kelengkapan Belanja
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label>Rekening Belanja</label>
                            <select class="form-control select2bs4 " name="kd_rincian" style="width: 100%">
                                <option selected disabled value="">.: Pilih Rekening :.</option>
                                <?php
                                foreach ($getRefRek4 as $rek) {
                                    echo "<option value='{$rek['objek']}'>{$rek['objek']} - {$rek['nama_objek']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label>Kelengkapan Belanja</label>
                            <select class="form-control select2bs4 " name="id_bukti[]" multiple="multiple"
                                    style="width: 100%">
                                <?php
                                foreach ($getBuktiBelanja as $bkt) {
                                    echo "<option value='{$bkt['id_bukti']}.{$bkt['uraian']}'>{$bkt['uraian']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <?= getCsrf(); ?>
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
                    Bukti Kelengkapan Belanja
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-sm  table-bordered tabel_3" style="width: 100%">
                                <thead>
                                <tr>
                                    <th width="8%">Kode</th>
                                    <th>Belanja</th>
                                    <th>Bukti</th>
                                    <th width="8%"><i class="fa fa-cog"></i></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($getMapBelanja as $row) {
                                    ?>
                                    <tr>
                                        <td><?= $row['kd_rincian']; ?></td>
                                        <td><?= $row['nama_objek']; ?></td>
                                        <td><?= $row['nama_bukti']; ?></td>
                                        <td class="text-center">
                                            <?= btnAction('delete', attrBtn: "data-map_id='{$row['map_id']}'", classBtn: 'btn-delete'); ?>
                                        </td>
                                    </tr>
                                    <?php
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
<script>

    $('.btn-delete').click(function () {
        swalWithBootstrapButtons({
            title: `Apa anda yakin Menghapus ?`,
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
                    data: {map_id: $(this).data('map_id'), token: $('#token').val()},
                    success: (res) => {
                        notifSmartAlert(res.status, res.message)
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

</script>