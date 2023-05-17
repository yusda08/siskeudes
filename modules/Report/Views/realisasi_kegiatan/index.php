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
            <?php if ($kd_desa) {
//                $dataArray = [];
//                foreach ($getRealisasi as $rea) {
//                    if ($rea['kd_keg'] === '08.2001.01.01.04.'
//                        and $rea['kd_rincian'] == '5.2.6.99.') {
//                        $dataArray[] = $rea;
//                    }
//                };
//                echo json_encode($dataArray);

                ?>
                <div class="card card-outline">
                    <!-- /.box-header -->
                    <div class="card-body">
                        <a target="_blank" href="<?= base_url(uri_string() . "/excel?desa=$kd_desa"); ?>"
                           class="btn btn-success btn-flat"><i class="fa fa-download"></i> Download Excel</a>
                        <h5 class="text-center">Laporan Realisasi Kegiatan
                            <br><?= textCapital($desa['nama_desa']); ?>
                            <br>Tahun Anggaran <?= aksesLog()['tahun']; ?></h5>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead>
                                        <tr>
                                            <th colspan="2" rowspan="3">Kode Rek</th>
                                            <th rowspan="3">Uraian</th>
                                            <th colspan="5">Output</th>
                                            <th colspan="6">Sumber Dana</th>
                                        </tr>
                                        <tr>
                                            <th colspan="3">RENCANA</th>
                                            <th colspan="2">REALISASI</th>
                                            <th rowspan="2">Dana Desa</th>
                                            <th rowspan="2">Alokasi Dana Desa</th>
                                            <th rowspan="2">BHPRD</th>
                                            <th rowspan="2">PBK</th>
                                            <th rowspan="2">PAD</th>
                                            <th rowspan="2">DLL</th>
                                        </tr>
                                        <tr>
                                            <th>Volume</th>
                                            <th>Satuan</th>
                                            <th>Anggaran</th>
                                            <th>Anggaran</th>
                                            <th>Capaian</th>
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
                                            foreach ($getRealisasi as $kuitansi) {
                                                if (substr($kuitansi['kd_keg'], 0, -7) === $bidang['kd_bid']) {
                                                    $realisasiBid += $kuitansi['realisasi'];
                                                }
                                            }

                                            $anggaranBidADD = 0;
                                            $anggaranBidDDS = 0;
                                            $anggaranBidBHPRD = 0;
                                            $anggaranBidPBK = 0;
                                            $anggaranBidPAD = 0;
                                            $anggaranBidDLL = 0;
                                            foreach ($getRabRinc as $rinci) {
                                                if ($bidang['kd_bid'] === substr($rinci['kd_keg'], 0, -7)) {
                                                    if ($rinci['sumberdana'] == 'ADD') {
                                                        $anggaranBidADD += $rinci['anggaran'];
                                                    } elseif ($rinci['sumberdana'] == 'DLL') {
                                                        $anggaranBidDLL += $rinci['anggaran'];
                                                    } elseif ($rinci['sumberdana'] == 'DDS') {
                                                        $anggaranBidDDS += $rinci['anggaran'];
                                                    } elseif ($rinci['sumberdana'] == 'PBH') {
                                                        $anggaranBidPBK += $rinci['anggaran'];
                                                    }
                                                }
                                            }

                                            $persenRealisasiBid = @($realisasiBid / $anggaranBid) * 100;
                                            ?>
                                            <tr class="bg-gray-light" style="font-weight: bold">
                                                <td><?= $noBidang; ?></td>
                                                <td></td>
                                                <td><?= $bidang['nama_bidang']; ?></td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-right"><?= numberFormat($anggaranBid); ?></td>
                                                <td class="text-right"><?= numberFormat($realisasiBid); ?></td>
                                                <td class="text-center">
                                                    <?= $persenRealisasiBid == 0 || $persenRealisasiBid == 100
                                                        ? numberFormat($persenRealisasiBid)
                                                        : numberFormat($persenRealisasiBid, 2); ?>
                                                </td>
                                                <td class="text-right"><?= numberFormat($anggaranBidDDS); ?></td>
                                                <td class="text-right"><?= numberFormat($anggaranBidADD); ?></td>
                                                <td class="text-right"><?= numberFormat($anggaranBidBHPRD); ?></td>
                                                <td class="text-right"><?= numberFormat($anggaranBidPBK); ?></td>
                                                <td class="text-right"><?= numberFormat($anggaranBidPAD); ?></td>
                                                <td class="text-right"><?= numberFormat($anggaranBidDLL); ?></td>
                                            </tr>
                                            <?php
                                            $noSubbid = 1;
                                            foreach ($getSubBidang as $subbid) {
                                                $anggaranSubBid = 0;
                                                foreach ($getKegiatan as $kegiatan) {
                                                    if ($subbid['kd_sub'] === $kegiatan['kd_sub']) {
                                                        $anggaranSubBid += $kegiatan['pagu'];
                                                    }
                                                }
                                                $realisasiSubBid = 0;
                                                foreach ($getRealisasi as $kuitansi) {
                                                    if (substr($kuitansi['kd_keg'], 0, -3) === $subbid['kd_sub']) {
                                                        $realisasiSubBid += $kuitansi['realisasi'];
                                                    }
                                                }
                                                $anggaranSubbidADD = 0;
                                                $anggaranSubbidDDS = 0;
                                                $anggaranSubbidBHPRD = 0;
                                                $anggaranSubbidPBK = 0;
                                                $anggaranSubbidPAD = 0;
                                                $anggaranSubbidDLL = 0;
                                                foreach ($getRabRinc as $rinci) {
                                                    if ($subbid['kd_sub'] === substr($rinci['kd_keg'], 0, -3)) {
                                                        if ($rinci['sumberdana'] == 'ADD') {
                                                            $anggaranSubbidADD += $rinci['anggaran'];
                                                        } elseif ($rinci['sumberdana'] == 'DLL') {
                                                            $anggaranSubbidDLL += $rinci['anggaran'];
                                                        } elseif ($rinci['sumberdana'] == 'DDS') {
                                                            $anggaranSubbidDDS += $rinci['anggaran'];
                                                        } elseif ($rinci['sumberdana'] == 'PBH') {
                                                            $anggaranSubbidPBK += $rinci['anggaran'];
                                                        }
                                                    }
                                                }


                                                $persenRealisasiSubBid = @($realisasiSubBid / $anggaranSubBid) * 100;
                                                if ($subbid['kd_bid'] == $bidang['kd_bid']) {
                                                    ?>
                                                    <tr class="bg-gray-light" style="font-weight: bold">
                                                        <td><?= $noBidang . '.' . $noSubbid; ?></td>
                                                        <td></td>
                                                        <td><?= $subbid['nama_subbidang']; ?></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-right"><?= numberFormat($anggaranSubBid); ?></td>
                                                        <td class="text-right"><?= numberFormat($realisasiSubBid); ?></td>
                                                        <td class="text-center">
                                                            <?= $persenRealisasiSubBid == 0 || $persenRealisasiSubBid == 100
                                                                ? numberFormat($persenRealisasiSubBid)
                                                                : numberFormat($persenRealisasiSubBid, 2); ?>
                                                        </td>
                                                        <td class="text-right"><?= numberFormat($anggaranSubbidDDS); ?></td>
                                                        <td class="text-right"><?= numberFormat($anggaranSubbidADD); ?></td>
                                                        <td class="text-right"><?= numberFormat($anggaranSubbidBHPRD); ?></td>
                                                        <td class="text-right"><?= numberFormat($anggaranSubbidPBK); ?></td>
                                                        <td class="text-right"><?= numberFormat($anggaranSubbidPAD); ?></td>
                                                        <td class="text-right"><?= numberFormat($anggaranSubbidDLL); ?></td>
                                                    </tr>
                                                    <?php
                                                    $noKeg = 1;
                                                    foreach ($getKegiatan as $kegiatan) {
                                                        $realisasiKeg = 0;
                                                        foreach ($getRealisasi as $rea) {
                                                            if ($rea['kd_keg'] === $kegiatan['kd_keg']) {
                                                                $realisasiKeg += $rea['realisasi'];
                                                            }
                                                        }
                                                        $persenRealisasiKeg = 0;
                                                        if (!empty($kegiatan['pagu'])) {
                                                            $persenRealisasiKeg = @($realisasiKeg / $kegiatan['pagu']) * 100;
                                                        }

                                                        $anggaranKegADD = 0;
                                                        $anggaranKegDDS = 0;
                                                        $anggaranKegBHPRD = 0;
                                                        $anggaranKegPBK = 0;
                                                        $anggaranKegPAD = 0;
                                                        $anggaranKegDLL = 0;
                                                        foreach ($getRabRinc as $rinci) {
                                                            if ($kegiatan['kd_keg'] === $rinci['kd_keg']) {
                                                                if ($rinci['sumberdana'] == 'ADD') {
                                                                    $anggaranKegADD += $rinci['anggaran'];
                                                                } elseif ($rinci['sumberdana'] == 'DLL') {
                                                                    $anggaranKegDLL += $rinci['anggaran'];
                                                                } elseif ($rinci['sumberdana'] == 'DDS') {
                                                                    $anggaranKegDDS += $rinci['anggaran'];
                                                                } elseif ($rinci['sumberdana'] == 'PBH') {
                                                                    $anggaranKegPBK += $rinci['anggaran'];
                                                                }
                                                            }
                                                        }


                                                        if ($subbid['kd_sub'] === $kegiatan['kd_sub']) { ?>
                                                            <tr class="bg-gray-light">
                                                                <td><?= $noBidang . '.' . $noSubbid . '.' . $noKeg; ?></td>
                                                                <td><?= $kegiatan['kd_keg']; ?></td>
                                                                <td><?= $kegiatan['nama_kegiatan']; ?></td>
                                                                <td class="text-center"><?= $kegiatan['nilai']; ?></td>
                                                                <td class="text-center"><?= $kegiatan['satuan']; ?></td>
                                                                <td class="text-right"><?= numberFormat($kegiatan['pagu']); ?></td>
                                                                <td class="text-right"><?= numberFormat($realisasiKeg); ?></td>
                                                                <td class="text-center">
                                                                    <?= $persenRealisasiKeg == 0 || $persenRealisasiKeg == 100
                                                                        ? numberFormat($persenRealisasiKeg)
                                                                        : numberFormat($persenRealisasiKeg, 2); ?>
                                                                </td>
                                                                <td class="text-right"><?= numberFormat($anggaranKegDDS); ?></td>
                                                                <td class="text-right"><?= numberFormat($anggaranKegADD); ?></td>
                                                                <td class="text-right"><?= numberFormat($anggaranKegBHPRD); ?></td>
                                                                <td class="text-right"><?= numberFormat($anggaranKegPBK); ?></td>
                                                                <td class="text-right"><?= numberFormat($anggaranKegPAD); ?></td>
                                                                <td class="text-right"><?= numberFormat($anggaranKegDLL); ?></td>
                                                            </tr>
                                                            <?php
                                                            foreach ($getRab as $rab) {
                                                                if ($kegiatan['kd_keg'] === $rab['kd_keg']) {
                                                                    $anggaranADD = 0;
                                                                    $anggaranDDS = 0;
                                                                    $anggaranBHPRD = 0;
                                                                    $anggaranPBK = 0;
                                                                    $anggaranPAD = 0;
                                                                    $anggaranDLL = 0;
                                                                    foreach ($getRabRinc as $rinci) {
                                                                        if ($rab['kd_keg'] === $rinci['kd_keg']
                                                                            and $rab['kd_rincian'] === $rinci['kd_rincian']
                                                                            and $rab['kd_subrinci'] === $rinci['kd_subrinci']) {
                                                                            if ($rinci['sumberdana'] == 'ADD') {
                                                                                $anggaranADD += $rinci['anggaran'];
                                                                            } elseif ($rinci['sumberdana'] == 'DLL') {
                                                                                $anggaranDLL += $rinci['anggaran'];
                                                                            } elseif ($rinci['sumberdana'] == 'DDS') {
                                                                                $anggaranDDS += $rinci['anggaran'];
                                                                            } elseif ($rinci['sumberdana'] == 'PBH') {
                                                                                $anggaranPBK += $rinci['anggaran'];
                                                                            }
                                                                        }
                                                                    }
                                                                    $realisasi = 0;
                                                                    foreach ($getRealisasi as $rea) {
                                                                        if ($rea['kd_keg'] === $rab['kd_keg']
                                                                            and $rea['kd_rincian'] == $rab['kd_rincian']
                                                                            and $rea['kd_subrinci'] == $rab['kd_subrinci']) {
                                                                            $realisasi += $rea['realisasi'];
                                                                        }
                                                                    }
                                                                    $persenRealisasi = 0;
                                                                    if (!empty($rab['anggaran'])) {
                                                                        $persenRealisasi = @($realisasi / $rab['anggaran']) * 100;
                                                                    }
                                                                    ?>
                                                                    <tr>
                                                                        <td></td>
                                                                        <td><?= $rab['kd_rincian'] . $rab['kd_subrinci']; ?></td>
                                                                        <td><?= $rab['nama_objek']; ?></td>
                                                                        <td class="text-center"></td>
                                                                        <td class="text-center"></td>
                                                                        <td class="text-right"><?= numberFormat($rab['anggaran']); ?></td>
                                                                        <td class="text-right"><?= numberFormat($realisasi); ?></td>
                                                                        <td class="text-center"><?= $persenRealisasi == 0 || $persenRealisasi == 100 ? numberFormat($persenRealisasi) : numberFormat($persenRealisasi, 2); ?></td>
                                                                        <td class="text-right"><?= numberFormat($anggaranDDS); ?></td>
                                                                        <td class="text-right"><?= numberFormat($anggaranADD); ?></td>
                                                                        <td class="text-right"><?= numberFormat($anggaranBHPRD); ?></td>
                                                                        <td class="text-right"><?= numberFormat($anggaranPBK); ?></td>
                                                                        <td class="text-right"><?= numberFormat($anggaranPAD); ?></td>
                                                                        <td class="text-right"><?= numberFormat($anggaranDLL); ?></td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            }
                                                            $noKeg++;
                                                        }
                                                    }
                                                    $noSubbid++;
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