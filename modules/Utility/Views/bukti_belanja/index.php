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
                            <label>Uraian Bukti Belanja</label>
                            <input type="text"
                                   class="form-control <?= ($validation->hasError('uraian')) ? 'is-invalid' : ''; ?> uraian"
                                   placeholder="Uraian Bukti" name="uraian" value="<?= old('uraian'); ?>" required>
                            <div class="invalid-feedback">
                                <?= $validation->getError('uraian'); ?>
                            </div>
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
                                    <th width="8%">No</th>
                                    <th>Uraian</th>
                                    <th width="8%"><i class="fa fa-cog"></i></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($getBuktiBelanja as $i => $row) {
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $i+1; ?></td>
                                        <td><?= $row['uraian']; ?></td>
                                        <td class="text-center">
                                            <?php
                                            $attrHps = " data-id_bukti='{$row['id_bukti']}'
                                                         data-uraian='{$row['uraian']}'";
                                            echo btn_hapus($attrHps, '', ' btn-xs btn-hapus');
                                            ?>
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

    $('.btn-hapus').click(function () {
        const uraian = $(this).data('uraian')
        swalWithBootstrapButtons({
            title: `Apa anda yakin Menghapus Bukti Belanja : ${uraian}`,
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
                    data: {id_bukti:$(this).data('id_bukti'), token:$('#token').val()},
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

</script>