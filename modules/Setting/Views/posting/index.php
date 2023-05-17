<?php
$S_Kuitansi = new \Modules\Master\Services\KuitansiService();
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-5">
            <div class="card card-outline">
                <form method="GET">
                    <div class="card-body">
                        <div class="row form-group">
                            <div class="col-md-8">
                                <select class="select2bs4 desa" name="desa" style="width: 100%">
                                    <option selected disabled value="">.: Pilih Desa :.</option>
                                    <?php
                                    foreach ($getDataDesa as $row_desa) {
                                        $attrDesa = $kd_desa == $row_desa['kd_desa'] ? 'selected' : '';
                                        echo "<option $attrDesa value='{$row_desa['kd_desa']}'>{$row_desa['nama_desa']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-primary btn-block"><i class="fa fa-search"></i> Search</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php
            if ($kd_desa) {
                ?>
                <div class="card card-outline">
                    <div class="card-header bg-gray">
                        Data SPP
                    </div>
                    <!-- /.box-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered" width="100%">
                                        <thead>
                                        <tr>
                                            <th width="15%">No SPP</th>
                                            <th>Tanggal</th>
                                            <th>Jenis</th>
                                            <th>Keterangan</th>
                                            <th>Jumlah</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach ($getSpp as $spp) {
                                            $getKuitansi = $S_Kuitansi->getKuitansiSppFindAll($spp['jn_spp'], ['no_spp' => $spp['no_spp']]);
                                            ?>
                                            <tr class="bg-gray-light">
                                                <td><?= $spp['no_spp']; ?></td>
                                                <td><?= tgl_indo($spp['tgl_spp']); ?></td>
                                                <td><?= $spp['jn_spp']; ?></td>
                                                <td><?= $spp['keterangan']; ?></td>
                                                <td><?= numberFormat($spp['jumlah']); ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">
                                                    <label>Kuitansi :</label>
                                                    <table class="table table-bordered table-sm">
                                                        <tbody>
                                                        <?php
                                                        foreach ($getKuitansi as $kwt) {
                                                            if ($kwt['no_spp'] == $spp['no_spp']) {
                                                                ?>
                                                                <tr>
                                                                    <td><?= $kwt['no_bukti']; ?></td>
                                                                    <td class="text-center"><?= $kwt['kd_rincian'] . $kwt['kd_subrinci']; ?></td>
                                                                    <td class="text-center"><?= tgl_indo_angka($kwt['tgl_bukti']); ?></td>
                                                                    <td><?= $kwt['nm_penerima']; ?></td>
                                                                    <td>
                                                                        <?= $kwt['keterangan']; ?>
                                                                    </td>
                                                                    <td class="text-right"><?= numberFormat($kwt['nilai']); ?></td>

                                                                    <td class="text-center">
                                                                        <?php
                                                                        if ($kwt['status_kuitansi'] == 1) {
                                                                            echo btnAction('posting', attrBtn: "data-id_bukti_kuitansi='{$kwt['id_bukti_kuitansi']}'", labelBtn: 'Batal Posting', classBtn: 'btn-xs btn-block btn-posting');
                                                                        } else {
                                                                            echo btnAction('posting', attrBtn: 'disabled', labelBtn: 'Batal Posting', classBtn: 'btn-xs btn-block');
                                                                        } ?>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <?php
                                        } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else {
                statusWarning(' Pilih Desa !!!', 'Silahkan Pilih Desa Terlebih Dahulu');
            } ?>
        </div>

    </div>
</div>
<?= $this->include('backend/javasc'); ?>
<script>

    $('.btn-posting').click(function () {
        const id_bukti_kuitansi = $(this).data('id_bukti_kuitansi');
        swalWithBootstrapButtons({
            title: 'Apa anda yakin Membatalkan Posting',
            text: "Silahkan Klik Tombol Batalkan Untuk melakukan Aksi",
            type: 'info',
            showCancelButton: true,
            confirmButtonText: 'Batalkan ',
            cancelButtonText: 'Tutup',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: siteUrl('setting/posting/cancel'),
                    dataType: 'json',
                    data: {id_bukti_kuitansi},
                    success: (res) => {
                        notifSmartAlert(res.status, res.message)
                    },
                    error: (request, status, error) => {
                        notifSmartAlert(false, request.responseText);
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons('Cancel', 'Menutup alert', 'error')
            }
        })
    });
</script>