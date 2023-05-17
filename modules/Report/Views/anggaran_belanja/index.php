<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card card-outline">
                <div class="card-header">Desa</div>
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
                        <a target="_blank" href="<?= base_url(uri_string() . "/excel?desa=$kd_desa"); ?>"
                           class="btn btn-success btn-flat"><i class="fa fa-download"></i> Download Excel</a>
                        <h5 class="text-center">Laporan Pelaksanaan
                            <br>Anggaran Belanja Desa
                            <br><?= textCapital($desa['nama_desa']); ?>
                            <br>Tahun Anggaran <?= aksesLog()['tahun']; ?></h5>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead>
                                        <tr>
                                            <th width="5%">Kode</th>
                                            <th width="15%">Kode Rekening</th>
                                            <th>Uraian</th>
                                            <th>Anggaran</th>
                                            <th>Realisasi</th>
                                            <th width="12%">Keterangan</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $noBidang = 1;
                                        foreach ($getBidang as $bidang) {
                                            $anggaranBid = 0;
                                            foreach ($getKegiatan as $kegiatan) {
                                                if ($bidang['kd_bid'] === $kegiatan['kd_bid']) {
                                                    $anggaranBid += $kegiatan['pagu'];
                                                }
                                            }
                                            $realisasiBid = 0;
                                            foreach ($getKuitansiAll as $kuitansi) {
                                                if (substr($kuitansi['kd_keg'], 0, -7) === $bidang['kd_bid']) {
                                                    $realisasiBid += $kuitansi['realisasi'];
                                                }
                                            }
                                            ?>
                                            <tr class="bg-gray-light">
                                                <td><?= $noBidang; ?></td>
                                                <td></td>
                                                <td><?= $bidang['nama_bidang']; ?></td>
                                                <td class="text-right"><?= numberFormat($anggaranBid); ?></td>
                                                <td class="text-right"><?= numberFormat($realisasiBid); ?></td>
                                                <td></td>
                                            </tr>
                                            <?php
                                            $noSubBidang = 1;
                                            foreach ($getSubBidang as $subbidang) {
                                                if ($subbidang['kd_bid'] === $bidang['kd_bid']) {
                                                    $anggaranSubBid = 0;
                                                    foreach ($getKegiatan as $kegiatan) {
                                                        if ($subbidang['kd_sub'] === $kegiatan['kd_sub']) {
                                                            $anggaranSubBid += $kegiatan['pagu'];
                                                        }
                                                    }

                                                    $realisasiSubBid = 0;
                                                    foreach ($getKuitansiAll as $kuitansi) {
                                                        if (substr($kuitansi['kd_keg'], 0, -3) === $subbidang['kd_sub']) {
                                                            $realisasiSubBid += $kuitansi['realisasi'];
                                                        }
                                                    }

                                                    ?>
                                                    <tr class="bg-gray-light">
                                                        <td><?= $noBidang . '.' . $noSubBidang; ?></td>
                                                        <td></td>
                                                        <td><?= $subbidang['nama_subbidang']; ?></td>
                                                        <td class="text-right"><?= numberFormat($anggaranSubBid); ?></td>
                                                        <td class="text-right"><?= numberFormat($realisasiSubBid); ?></td>
                                                        <td></td>
                                                    </tr>
                                                    <?php
                                                    $noKeg = 1;
                                                    foreach ($getKegiatan as $kegiatan) {
                                                        if ($subbidang['kd_sub'] === $kegiatan['kd_sub']) {
                                                            $realisasiKeg = 0;
                                                            foreach ($getKuitansiAll as $kuitansi) {
                                                                if ($kuitansi['kd_keg'] === $kegiatan['kd_keg']) {
                                                                    $realisasiKeg += $kuitansi['realisasi'];
                                                                }
                                                            }
                                                            ?>
                                                            <tr class="bg-gray-light">
                                                                <td><?= $noBidang . '.' . $noSubBidang . '.' . $noKeg; ?></td>
                                                                <td></td>
                                                                <td><?= $kegiatan['nama_kegiatan']; ?></td>
                                                                <td class="text-right"><?= numberFormat($kegiatan['pagu']); ?></td>
                                                                <td class="text-right"><?= numberFormat($realisasiKeg); ?></td>
                                                                <td></td>
                                                            </tr>
                                                            <?php
                                                            foreach ($getRab as $rab) {
                                                                if ($rab['kd_keg'] === $kegiatan['kd_keg']) {
                                                                    $realisasiRab = 0;
                                                                    foreach ($getKuitansiAll as $kuitansi) {
                                                                        if ($kuitansi['kd_rincian'] === $rab['kd_rincian']
                                                                            and $kuitansi['kd_keg'] === $rab['kd_keg']
                                                                            and $kuitansi['kd_subrinci'] === $rab['kd_subrinci']
                                                                        ) {
                                                                            $realisasiRab += $kuitansi['realisasi'];
                                                                        }
                                                                    }
                                                                    ?>
                                                                    <tr>
                                                                        <td><?= $noBidang . '.' . $noSubBidang . '.' . $noKeg; ?></td>
                                                                        <td><?= $rab['kd_rincian'] . $rab['kd_subrinci']; ?></td>
                                                                        <td><?= $rab['nama_objek']; ?></td>
                                                                        <td class="text-right"><?= numberFormat($rab['anggaran_stlh_pak']); ?></td>
                                                                        <td class="text-right"><?= numberFormat($realisasiRab); ?></td>
                                                                        <td></td>
                                                                    </tr>

                                                                    <?php
                                                                }
                                                            }
                                                            $noKeg++;
                                                        }
                                                    }
                                                    $noSubBidang++;
                                                }
                                            }
                                            $noBidang++;
                                        }
                                        ?>
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