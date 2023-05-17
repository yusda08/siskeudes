<div class="container-fluid">
    <div class="jumbotron jumbotron-fluid text-center ">
        <div class="container">
            <img class="img-responsive" src="<?= logoKab(); ?>" width="100px" hieght="100px">
            <h1 class="display-5"></h1>
            <p class="lead">Sistem Informasi Laporan Pertanggungjawaban Realisasi Kegiatan Desa
                <br>Pemerintah Kabupaten Tabalong<br>
            </p>
            <p style="font-size: 18pt" class="title">Total Anggaran : Rp. <span class="total-anggaran">0</span></p>
            <p style="font-size: 18pt" class="title">Total Realisasi : Rp. <span class="total-realisasi">0</span>
                (<span class="persen-realisasi">0 %</span>)</p>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <label>Pagu Anggaran :</label>
        </div>
        <?php foreach ($getRek2 as $rek2) { ?>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h4>Rp. <span class="kelompok-<?= str_replace('.', '', $rek2['kelompok']); ?>"></span></h4>
                        <p>
                            <?= $rek2['kelompok'] . ' ' . $rek2['nama_kelompok']; ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="row">
        <div class="col-md-12">
            <label>Pagu Realisasi :</label>
        </div>
        <?php foreach ($getRek2 as $rek2) { ?>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h4>Rp. <span class="realisasi-<?= str_replace('.', '', $rek2['kelompok']); ?>"></span></h4>
                        Persen : <span
                                class="persen-realisasi-<?= str_replace('.', '', $rek2['kelompok']); ?>">0 %</span>
                        <p>
                            <?= $rek2['kelompok'] . ' ' . $rek2['nama_kelompok']; ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Pagu Per Desa
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th rowspan="2">Kode</th>
                                <th rowspan="2">Desa</th>
                                <th rowspan="2">Anggaran</th>
                                <th colspan="2">Realisasi</th>
                            </tr>
                            <tr>
                                <th>Pagu</th>
                                <th>Persen</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $totalAnggaran = 0;
                            $totalRealisasi = 0;
                            foreach ($getDesa as $desa) {
                                $anggaranDesa = 0;
                                foreach ($getAnggaranDesa as $anggaran) {
                                    if ($anggaran['kd_desa'] == $desa['kd_desa']) {
                                        $anggaranDesa = (int)$anggaran['anggaran'];
                                        $totalAnggaran += $anggaran['anggaran'];
                                        break;
                                    }
                                }

                                $realisasiDesa = 0;
                                foreach ($getRealisasiDesa as $realisasi) {
                                    if ($realisasi['kd_desa'] == $desa['kd_desa']) {
                                        $realisasiDesa = (int)$realisasi['realisasi'];
                                        $totalRealisasi += $realisasi['realisasi'];
                                        break;
                                    }
                                }
                                $persenRealisasi = @($realisasiDesa / $anggaranDesa) * 100;
                                ?>
                                <tr>
                                    <td><?= $desa['kd_desa']; ?></td>
                                    <td><?= $desa['nama_desa']; ?></td>
                                    <td class="text-right"><?= numberFormat($anggaranDesa); ?></td>
                                    <td class="text-right"><?= numberFormat($realisasiDesa); ?></td>
                                    <td class="text-center"><?= numberFormat($persenRealisasi, 2) . ' %'; ?></td>
                                </tr>
                                <?php
                            }
                            $totalPersenRealisasi = @($totalRealisasi / $totalAnggaran) * 100;
                            ?>
                            </tbody>
                            <tfoot>
                            <tr class="bg-gray">
                                <td colspan="2"></td>
                                <td class="text-right"><?= numberFormat($totalAnggaran); ?></td>
                                <td class="text-right"><?= numberFormat($totalRealisasi); ?></td>
                                <td class="text-center"><?= numberFormat($totalPersenRealisasi, 2) . ' %'; ?></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('backend/javasc'); ?>
<script>

    $(document).ready(async function () {
        loadAnggaran();
    })

    async function loadAnggaran() {
        const getDataRealisasi = await getRealisasi();
        const dataRealisasi = getDataRealisasi.data;
        let totalRealisasi = 0;

        const getDataAnggaran = await getAnggaran();
        const dataAnggaran = getDataAnggaran.data;
        let totalAnggaran = 0;

        dataAnggaran.forEach(resAnggaran => {
            const kdRincian = resAnggaran.kd_rincian.split('.').join('');
            $(`.kelompok-${kdRincian}`).text(numberWithCommas((resAnggaran.anggaran).toFixed(2)))
            totalAnggaran += resAnggaran.anggaran;
        })
        $('.total-anggaran').text(numberWithCommas(totalAnggaran))

        dataRealisasi.forEach(resRealisasi => {
            const kdRincian = resRealisasi.kd_rincian.split('.').join('');
            let rincianAnggaran = 0;
            dataAnggaran.forEach(res => {
                if (res.kd_rincian === resRealisasi.kd_rincian) {
                    rincianAnggaran = res.anggaran;
                }
            })
            const persenRelaisasi = (resRealisasi.realisasi / rincianAnggaran) * 100;
            $(`.realisasi-${kdRincian}`).text(numberWithCommas((resRealisasi.realisasi).toFixed(2)))
            $(`.persen-realisasi-${kdRincian}`).text(parseFloat(persenRelaisasi).toFixed(2) + ' %')
            totalRealisasi += parseInt(resRealisasi.realisasi);
        })

        const persenRealisasi = (totalRealisasi / totalAnggaran) * 100;
        $('.total-realisasi').text(numberWithCommas(totalRealisasi))
        $('.persen-realisasi').text(parseFloat(persenRealisasi).toFixed(2) + ' %')
    }

    const getAnggaran = () => {
        return $.getJSON(baseUrl('/master/load-anggaran'));
    }

    const getRealisasi = () => {
        return $.getJSON(baseUrl('/master/load-realisasi'));
    }

</script>
