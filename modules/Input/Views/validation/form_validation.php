<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <?php
            if ($kuitansi['status_validasi'] == 1) {
                echo "<h3 class='alert alert-success'>Selesai Validasi Data</h3>";
            }
            if ($kuitansi['status_kuitansi'] == 2) {
                echo "<h3 class='alert alert-warning'>Koreksi data</h3>";
            };
            ?>
            <div class="card card-outline">
                <?= form_open('validasi-belanja/validasi'); ?>
                <?= getCsrf(); ?>
                <div class="card-header bg-gray">
                    Kuitansi No. <?= $no_bukti; ?>
                    <div class="card-tools">
                        <a href="<?= site_url("validasi-belanja?desa=" . $spp['kd_desa']); ?>"
                           class="btn btn-danger btn-xs"><i class="fa fa-backward"></i> Kembali</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm tabel_2">
                            <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Uraian</th>
                                <th>File Name</th>
                                <th><i class="fa fa-download"></i></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $statusValidasi = 'false';
                            $ttlBukti = count($getDataBukti);
                            $ttlValidasi = 0;
                            foreach ($getDataBukti as $i => $bukti) {
                                $ttlValidasi += $bukti['status_validasi'];
                                ?>
                                <tr>
                                    <td class="text-center"><?= $i + 1; ?></td>
                                    <td class=""><?= $bukti['uraian']; ?></td>
                                    <td class="text-center">
                                        <a target="_blank"
                                           href="<?= base_url($bukti['file_path'] . '/' . $bukti['file_name']); ?>"
                                           class="btn btn-danger"><i class="fa fa-download"></i> Download</a>
                                    </td>
                                    <td class="text-center">
                                        <textarea name="catatan_validasi[]" class="form-control"
                                                  placeholder="Catatan Verifikasi" cols="20"
                                                  required><?= $bukti['catatan_validasi']; ?></textarea>
                                        <input type="hidden" class="form-control" name="id_bukti_belanja[]"
                                               value="<?= $bukti['id_bukti_belanja']; ?>" required>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php
                if ($kuitansi['status_kuitansi'] == 1 and $kuitansi['status_validasi'] == 0) {
                    ?>
                    <div class="card-footer">

                        <div class="row justify-content-between">
                            <div class="col-md-12">
                                <?= btnAction('save', labelBtn: 'Simpan'); ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?= form_close(); ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-gray">Data Kuitansi</div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tbody>
                        <tr>
                            <td width="30%">No. Bukti</td>
                            <td><?= $kuitansi['no_bukti']; ?></td>
                        </tr>
                        <tr>
                            <td width="30%">Rekening</td>
                            <td><?= $kuitansi['kd_rincian'] . $kuitansi['kd_subrinci']; ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td><?= tgl_indo_angka($kuitansi['tgl_bukti']); ?></td>
                        </tr>
                        <tr>
                            <td>Keterangan</td>
                            <td><?= $kuitansi['keterangan']; ?></td>
                        </tr>
                        <tr>
                            <td>Penerima</td>
                            <td><?= $kuitansi['nm_penerima']; ?></td>
                        </tr>
                        <tr>
                            <td>Nilai</td>
                            <td>Rp. <?= numberFormat($kuitansi['nilai']); ?></td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="form-group mt-3 justify-content-between">

                        <?php
                        if ($ttlBukti == $ttlValidasi and $kuitansi['status_kuitansi'] == 1 and $kuitansi['status_validasi'] == 0) {
                            echo form_open('validasi-belanja/posting');
                            echo getCsrf();
                            echo form_input(data: 'kd_desa', value: $kuitansi['kd_desa'], type: 'hidden');
                            echo form_input(data: 'no_bukti', value: $kuitansi['no_bukti'], type: 'hidden');
                            echo form_input(data: 'status_validasi', value: 1, type: 'hidden');
                            echo btnAction('posting', labelBtn: 'Posting', classBtn: 'btn-flat btn-block');
                            echo form_close();
                            echo '<br>';
                            echo btnAction('update', attrBtn: "type='button' data-no_bukti='{$kuitansi['no_bukti']}'", labelBtn: 'Koreksi', classBtn: 'btn-flat btn-block btn-koreksi');
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->include('backend/javasc'); ?>
<script>
    $('.btn-koreksi').click(function () {
        const no_bukti = $(this).data('no_bukti')
        swalWithBootstrapButtons({
            title: `Apa anda yakin mengkoreksi data ini ?`,
            text: "Silahkan Klik Tombol Koreksi Untuk melakukan Aksi",
            type: 'info',
            showCancelButton: true,
            confirmButtonText: 'Koreksi ',
            cancelButtonText: 'Batal ',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: siteUrl('validasi-belanja/koreksi'),
                    dataType: 'json',
                    data: {no_bukti, status_kuitansi: '2', token: $('#token').val()},
                    success: (res) => {
                        notifSmartAlert(res.status, res.message)
                    },
                    error: (request, status, error) => {
                        notifSmartAlert(false, request.responseText);
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons('Cancel', 'Tidak ada aksi hapus data', 'error'
                )
            }
        })
    })
</script>