<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card card-outline">
                <?= form_open(uri_string() . '/input_data'); ?>
                <?= getCsrf(); ?>
                <div class="card-header">
                    Bukti Kelengkapan Belanja
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label>Pegawai</label>
                            <select class="form-control select2bs4 " name="nip_nik" style="width: 100%">
                                <option selected disabled value="">.: Pilih Pegawai :.</option>
                                <?php
                                foreach ($getPegawai as $pgw) {
                                    echo "<option value='{$pgw['nip_nik']}'>{$pgw['nama_pegawai']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label>Desa</label>
                            <select class="form-control select2bs4 " name="kd_desa[]" multiple="multiple"
                                    style="width: 100%">
                                <?php
                                foreach ($getDesa as $desa) {
                                    $attrDisabled = '';
                                    foreach ($getMapPgwDesa as $mapDesa) {
                                        if ($mapDesa['kd_desa'] == $desa['kd_desa']) {
                                            $attrDisabled = 'disabled';
                                            break;
                                        }
                                    }
                                    echo "<option {$attrDisabled} value='{$desa['kd_desa']}'>{$desa['nama_desa']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
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
                                    <th>NIP - NIK</th>
                                    <th>Pegawai</th>
                                    <th>Desa</th>
                                    <th width="8%"><i class="fa fa-cog"></i></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($getMapPgwDesa as $map_desa) {
                                    ?>
                                    <tr>
                                        <td><?= $map_desa['nip_nik']; ?></td>
                                        <td><?= $map_desa['nama_pegawai']; ?></td>
                                        <td><?= $map_desa['kd_desa'] . ' - ' . $map_desa['nama_desa']; ?></td>
                                        <td class="text-center">
                                            <?= btnAction('delete', attrBtn: "data-map_id='{$map_desa['map_id']}'", classBtn: 'btn-xs'); ?>
                                        </td>
                                    </tr>
                                <?php } ?>
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
                    url: siteUrl('delete_data'),
                    dataType: 'json',
                    data: {id_bukti: $(this).data('id_bukti'), token: $('#token').val()},
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