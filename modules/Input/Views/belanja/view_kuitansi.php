<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline">
                <div class="card-header bg-gray">
                    Data Kuitansi <?= $no_spp; ?>
                    <div class="card-tools">
                        <a href="<?= site_url("belanja?desa={$spp['kd_desa']}"); ?>" class="btn btn-danger"><i
                                    class="fa fa-backward"></i> Kembali</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover tabel_2" width="100%">
                            <thead>
                            <tr>
                                <th width="15%">No Kuitansi</th>
                                <th>Rekening</th>
                                <th>Tanggal</th>
                                <th>Penerima</th>
                                <th>Keterangan</th>
                                <th>Jumlah</th>
                                <th><i class="fa fa-check-square"></i></th>
                                <th width="8%"><i class="fa fa-check-square"></i></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($getKuitansi as $kwt) {
                                ?>
                                <tr>
                                    <td><?= $kwt['no_bukti']; ?></td>
                                    <td class="text-center"><?= $kwt['kd_rincian']; ?></td>
                                    <td class="text-center"><?= tgl_indo_angka($kwt['tgl_bukti']); ?></td>
                                    <td><?= $kwt['nm_penerima']; ?></td>
                                    <td>
                                        <?= $kwt['keterangan']; ?>
                                    </td>
                                    <td class="text-right"><?= numberFormat($kwt['nilai']); ?></td>
                                    <td class="text-center">
                                        <span class="badge badge-<?= $kwt['status_kuitansi'] ? 'primary' : 'danger'; ?>"><?= $kwt['status_kuitansi'] ? 'Selesai' : 'Belum Posting'; ?></span>
                                    </td>
                                    <td class="text-center">
                                        <?= form_open(site_url('belanja/add-kuitansi'), ['method' => 'GET']); ?>
                                        <input type="hidden" class="form-control" name="spp"
                                               value="<?= encodeUrl($no_spp); ?>">
                                        <input type="hidden" class="form-control" name="bukti"
                                               value="<?= encodeUrl($kwt['no_bukti']); ?>">
                                        <button class="btn btn-outline-primary btn-xs btn-block btn-flat">
                                            <i class="fa fa-search"></i> View
                                        </button>
                                        <?= form_close(); ?>
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
</div>
<?= $this->include('backend/javasc'); ?>
<script>
    $('.btn-bukti').click(function (e) {
        e.preventDefault();
        const thisTag = $('#modal-bukti')
        thisTag.modal('show')
        thisTag.find('.modal-title').text('Form Input');
        thisTag.find('.modal-body .no_bukti').val($(this).data('no_bukti'))
        thisTag.find('.modal-body .kd_desa').val($(this).data('kd_desa'))
        thisTag.find('.modal-body .kd_rincian').val($(this).data('kd_rincian'))
        thisTag.find('.modal-body .catatan').text($(this).data('catatan'))
        thisTag.find('.modal-body .saran_tl').text($(this).data('saran_tl'))
    });

    $('.check-bukti').click(function () {
        const status_bukti = $(this).is(':checked') ? 1 : 0;
        const id_bukti = $(this).data('id_bukti');
        const no_bukti = $(this).data('no_bukti');
        const kd_rincian = $(this).data('kd_rincian');
        const kd_desa = $(this).data('kd_desa');
        const token = $('#token').val();
        $.ajax({
            url: siteUrl('input_data/belanja/add_bukti'),
            type: 'POST',
            data: {status_bukti, id_bukti, no_bukti, kd_desa, kd_rincian},
            dataType: 'JSON',
            success: (res) => {
                console.log(res)
            }
        });
        // console.log(id_bukti)
        // if ($(this).is(':checked')) {
        //
        // } else {
        //     $.ajax({
        //         url: siteUrl('input_data/belanja/add_bukti'),
        //         type: 'POST',
        //         data: {status_bukti, id_bukti, no_bukti, kd_desa, kd_rincian, token},
        //         dataType: 'JSON',
        //         success: (res) => {
        //             console.log(res)
        //             // notifSmartAlert(res.status, res.ket);
        //         }
        //     });
        // }
    })

</script>