<?php
header("Content-type: application/vnd-ms-excel");
header('Content-Disposition: attachment; filename="realisasi_kegiatan_desa_' . $desa['nama_desa'] . '.xls"');
?>

<style>
    .table {
        font-family: sans-serif;
        color: #232323;
        border-collapse: collapse;
    }

    .table, th, td {
        border: 1px solid #999;
        padding: 8px 20px;
    }
</style>
<table class="table" style="width: 100%">
    <tr style="text-align: center">
        <td colspan="14">
            <span style="font-size: 14pt">
                Laporan Realisasi Kegiatan
                            <br><?= textCapital($desa['nama_desa']); ?>
                            <br>Tahun Anggaran <?= aksesLog()['tahun']; ?>
            </span>
        </td>
    </tr>
</table>
<table class="table table-bordered table-sm" style="width: 100%">
    <thead>
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
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
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
            if ($bidang['kd_bid'] === $kegiatan['kd_bid']) { ?>
                <tr class="bg-gray-light">
                    <td><?= $noBidang . '.' . $noKeg; ?></td>
                    <td></td>
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
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
        $noBidang++;
    }
    ?>
    </tbody>
</table>