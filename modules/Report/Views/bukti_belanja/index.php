<?php
$S_Kuitansi = new \Modules\Master\Services\KuitansiService();
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card card-outline">
                <div class="card-body">
                    <label>Pilih Desa</label>
                    <form method="GET">
                        <select class="select2bs4 " name="desa" style="width: 100%" onchange="this.form.submit()">
                            <option selected disabled value="">.: Pilih Desa :.</option>
                            <?php
                            foreach ($getDesa as $row_desa) {
                                $attrDesa = $kd_desa == $row_desa['kd_desa'] ? 'selected' : '';
                                echo "<option $attrDesa value='{$row_desa['kd_desa']}'>{$row_desa['nama_desa']}</option>";
                            }
                            ?>
                        </select>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <?php if ($kd_desa) { ?>
                <div class="card card-outline">
                    <!-- /.box-header -->
                    <div class="card-body">
                        <a target="_blank" href="<?= base_url(uri_string() . "/pdf?desa=$kd_desa"); ?>"
                           class="btn btn-danger btn-flat"><i class="fa fa-download"></i> Download Pdf</a>
                        <h5 class="text-center">Rekapitulasi Bukti Belanja
                            <br>APBDes <?= textCapital($desa['nama_desa']); ?>
                            <br>Tahun Anggaran <?= aksesLog()['tahun']; ?>
                        </h5>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
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
                                                <td class="text-right"><?= numberFormat($spp['jumlah']); ?></td>
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
                                                                        <span class="badge badge-<?= $kwt['status_kuitansi'] ? 'primary' : 'danger'; ?>"><?= $kwt['status_kuitansi'] ? 'Posting Selesai' : 'Belum Posting'; ?></span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="badge badge-<?= $kwt['status_validasi'] ? 'primary' : 'danger'; ?>"><?= $kwt['status_validasi'] ? 'Validasi Selesai' : 'Belum Validasi'; ?></span>
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
                statusWarning('Pilih Desa Terlebih dahulu');
            } ?>
        </div>
    </div>
</div>
<?= $this->include('backend/javasc'); ?>
<script>
</script>