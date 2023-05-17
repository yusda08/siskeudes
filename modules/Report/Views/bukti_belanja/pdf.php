<?php
echo isset($template_pdf) ? $this->extend($template_pdf) : '';
echo $this->section('content');

//header("Content-type: application/vnd-ms-excel");
//header('Content-Disposition: attachment; filename="laporan_bukti_belanja_' . $desa['nama_desa'] . '.xlsx"');

$S_Kuitansi = new \Modules\Master\Services\KuitansiService();
?>

    <style>
        .table {
            font-family: sans-serif;
            color: #232323;
            border-collapse: collapse;
        }

        .table, th, td {
            border: 1px solid #999;
            padding: 5px;
            font-size: 10pt;
        }
    </style>
    <table class="table" style="width: 100%">
        <tr>
            <th>
            <span style="font-size: 14pt">
                Rekapitulasi Bukti Belanja
                            <br>APBDes <?= textCapital($desa['nama_desa']); ?>
                            <br>Tahun Anggaran <?= aksesLog()['tahun']; ?>
            </span>
            </th>
        </tr>
    </table>
    <table class="table" style="width: 100%">
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
                <td colspan="5">
                    <label>Kuitansi :</label>
                    <table class="table table-bordered table-sm" style="width: 100%">
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

<?= $this->endSection() ?>