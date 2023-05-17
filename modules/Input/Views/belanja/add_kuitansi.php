<?php
$countMap = count($getMapBelanja);
$countBkt = count($getDataBukti);
$status = $countMap - $countBkt; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-5">
            <?= form_open_multipart(base_url('belanja/store-bukti')); ?>
            <?= getCsrf(); ?>
            <div class="card">
                <div class="card-header bg-gray">Form Add Bukti</div>
                <div class="card-body">
                    <h4 class="mt-3">Input Kelengkapan :</h4>
                    <?php
                    if (!$status) {
                        echo "<h5 class='alert alert-info'>Selesai</h5>";
                    }
                    foreach ($getMapBelanja as $item) {
                        $statusBukti = true;
                        foreach ($getDataBukti as $bkt) {
                            if ($bkt['id_bukti'] == $item['id_bukti']) {
                                $statusBukti = false;
                            }
                        }
                        if ($statusBukti) {
                            ?>
                            <div class="input-group mb-3">
                                <label for="<?= $item['id_bukti']; ?>"><?= $item['nama_bukti']; ?></label>
                                <input type="file" class="form-control-file" name="bukti[]"
                                       id="<?= $item['id_bukti']; ?>">
                                <input type="hidden" class="form-control" name="id_bukti[]"
                                       value="<?= $item['id_bukti']; ?>">
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <input type="hidden" class="form-control" name="spp" value="<?= $no_spp; ?>">
                    <input type="hidden" class="form-control" name="no_bukti" value="<?= $no_bukti; ?>">
                    <input type="hidden" class="form-control" name="kd_desa" value="<?= $kuitansi['kd_desa']; ?>">
                    <input type="hidden" class="form-control" name="kd_rincian"
                           value="<?= $kuitansi['kd_rincian']; ?>">
                </div>
                <div class="card-footer">
                    <?php
                    if ($status) {
                        echo btnAction('save', labelBtn: 'Simpan');
                    } else {
                        if ($kuitansi['status_kuitansi'] != 1)
                            echo btnAction('posting', attrBtn: "data-no_bukti={$no_bukti} type='button'", labelBtn: 'Posting', classBtn: 'btn-posting');
                    } ?>
                </div>
            </div>
            <?= form_close(); ?>
        </div>
        <div class="col-md-7">
            <div class="card card-outline">
                <div class="card-header bg-gray">
                    Kuitansi No. <?= $no_bukti; ?>
                    <div class="card-tools">
                        <a href="<?= site_url("belanja?desa=" . $kuitansi['kd_desa']) ?>" class="btn btn-danger"><i
                                    class="fa fa-backward"></i> Kembali</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-sm tabel_2">
                            <thead>
                            <tr>
                                <th>No Bukti</th>
                                <th>Uraian</th>
                                <th>Rincian</th>
                                <th>File Name</th>
                                <th>Catatan</th>
                                <th><i class="fa fa-download"></i></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($getDataBukti as $bukti) {
                                $params = json_encode($bukti);
                                ?>
                                <tr>
                                    <td><?= $bukti['no_bukti']; ?></td>
                                    <td class=""><?= $bukti['uraian']; ?></td>
                                    <td class="text-center"><?= $bukti['kd_rincian']; ?></td>
                                    <td class="text-center">
                                        <a target="_blank"
                                           href="<?= base_url($bukti['file_path'] . '/' . $bukti['file_name']); ?>"
                                           class="btn btn-danger"><i class="fa fa-download"></i> Download</a>
                                    </td>
                                    <td>
                                        <span class="text-bold"><?= $bukti['catatan_validasi']; ?></span>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        if ($kuitansi['status_kuitansi'] != 1) {
                                            echo btnAction('delete', attrBtn: "data-id_bukti_belanja={$bukti['id_bukti_belanja']}", classBtn: 'btn-sm btn-delete');
                                        } ?>
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
<?= $this->include('backend/javasc'); ?>
<script>
    $('.btn-delete').click(function () {
        const id_bukti_belanja = $(this).data('id_bukti_belanja');
        console.log(id_bukti_belanja)
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
                    url: siteUrl('belanja/delete-kuitansi'),
                    dataType: 'json',
                    data: {id_bukti_belanja, token: $('#token').val()},
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
    $('.btn-posting').click(function () {
        const no_bukti = $(this).data('no_bukti');
        swalWithBootstrapButtons({
            title: `Apa anda yakin Posting ?`,
            text: "Silahkan Klik Tombol Posting Untuk melakukan Aksi",
            type: 'info',
            showCancelButton: true,
            confirmButtonText: 'Posting ',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: siteUrl('belanja/posting-kuitansi'),
                    dataType: 'json',
                    data: {no_bukti, status_kuitansi: '1', token: $('#token').val()},
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