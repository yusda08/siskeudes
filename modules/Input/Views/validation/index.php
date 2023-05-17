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
                                                                if ($kwt['status_kuitansi'] == 1) {
                                                                    $badgeKuitansi = 'primary';
                                                                    $descKuitansi = 'Posting Selesai';
                                                                } elseif ($kwt['status_kuitansi'] == 2) {
                                                                    $badgeKuitansi = 'warning';
                                                                    $descKuitansi = 'Koreksi';
                                                                } else {
                                                                    $badgeKuitansi = 'danger';
                                                                    $descKuitansi = 'Belum Posting';
                                                                }
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
                                                                        <span class="badge badge-<?= $badgeKuitansi ?>"><?= $descKuitansi; ?></span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="badge badge-<?= $kwt['status_validasi'] ? 'primary' : 'danger'; ?>"><?= $kwt['status_validasi'] ? 'Validasi Selesai' : 'Belum Validasi'; ?></span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <?php
                                                                        if ($kwt['status_kuitansi'] == 1 or $kwt['status_kuitansi'] == 2) {
                                                                            ?>
                                                                            <?= form_open(site_url('validasi-belanja/form-validasi'), ['method' => 'GET']); ?>
                                                                            <input type="hidden" class="form-control"
                                                                                   name="spp"
                                                                                   value="<?= encodeUrl($spp['no_spp']); ?>">
                                                                            <input type="hidden" class="form-control"
                                                                                   name="bukti"
                                                                                   value="<?= encodeUrl($kwt['no_bukti']); ?>">
                                                                            <button class="btn btn-outline-primary btn-xs btn-block btn-flat">
                                                                                <i class="fa fa-search"></i> View
                                                                            </button>
                                                                            <?= form_close(); ?>
                                                                            <?php
                                                                        } else {
                                                                            echo btnAction('search', attrBtn: 'disabled', labelBtn: 'View', classBtn: 'btn-xs btn-block');
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
    $('.desa').change(function () {
        // $(this).find('option:selected').data('nip_nik')
        const desa = $(this).val();
        $.getJSON(siteUrl(`master/perencanaan/load_ta_bidang`), {desa}, function (respon) {
            console.log(respon);
            let htmls = `<option selected disabled value="">.: Pilih Bidang :.</option>`;
            respon.forEach((res) => {
                htmls += `<option value="${res.kd_bid}">${res.nama_bidang}</option>`;
            })
            $('.bidang').html(htmls);
        })
    });

    $('.bidang').change(function () {
        // $(this).find('option:selected').data('nip_nik')
        const bidang = $(this).val();
        $.getJSON(siteUrl(`master/perencanaan/load_ta_subbidang`), {bidang}, function (respon) {
            console.log(respon);
            let htmls = `<option selected disabled value="">.: Pilih Sub Bidang :.</option>`;
            respon.forEach((res) => {
                htmls += `<option value="${res.kd_sub}">${res.nama_subbidang}</option>`;
            })
            $('.subbidang').html(htmls);
        })
    });
</script>