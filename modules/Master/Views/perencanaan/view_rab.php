<?php
$arr = explode('.', $kd_keg);
$kd_bid = $kd_desa . $arr[2];
$kd_sub = $kd_bid . '.' . $arr[3] . '.';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-gray">
                    Tabel RAB
                </div>
                <div class="card-body">
                    <a href="<?= site_url($moduleUrl . "?desa={$kd_desa}&bidang={$kd_bid}&subbidang={$kd_sub}"); ?>"
                       class="btn btn-danger btn-flat"><i class="fa fa-backward"></i> Kembali</a>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered tabel_3" style="width: 100%">
                            <thead>
                            <tr>
                                <th rowspan="2">Kode</th>
                                <th rowspan="2">Objek / Uraian</th>
                                <th colspan="3">Anggaran</th>
                                <th colspan="3">PAK</th>
                                <th rowspan="2">Jenis Belanja</th>
                            </tr>
                            <tr>
                                <th>Volume</th>
                                <th>Harga Satuan</th>
                                <th>Pagu</th>
                                <th>Volume</th>
                                <th>Harga Satuan</th>
                                <th>Pagu</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($getTaRab as $rab) { ?>
                                <tr>
                                    <td><?= $rab['kd_rincian'] . $rab['kd_subrinci']; ?></td>
                                    <td><?= $rab['nama_objek']; ?></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-right"><?= numberFormat($rab['anggaran']); ?></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-right"><?= numberFormat($rab['anggaran_stlh_pak']); ?></td>
                                    <td class="text-right"></td>
                                </tr>
                                <?php
                                foreach ($getTaRabRinci as $rab_rinci) {
                                    if ($rab['kd_rincian'] == $rab_rinci['kd_rincian']) {
                                        ?>
                                        <tr>
                                            <td>
                                                <?php
                                                $attrEdt = "data-kd_desa='{$rab_rinci['kd_desa']}'
                                                            data-kd_keg='{$rab_rinci['kd_keg']}'
                                                            data-kd_rincian='{$rab_rinci['kd_rincian']}'
                                                            data-kd_subrinci='{$rab_rinci['kd_subrinci']}'
                                                            data-uraian='{$rab_rinci['uraian']}'
                                                            data-kd_jenis='{$rab_rinci['kd_jenis']}'
                                                            data-no_urut='{$rab_rinci['no_urut']}'";
                                                echo btn_edit($attrEdt, $ketEdt = ' ', $classEdt = ' btn-block btn-xs btn-edit'); ?>
                                            </td>
                                            <td><?= $rab_rinci['uraian']; ?></td>
                                            <td class="text-center"><?= $rab_rinci['jml_satuan'] . ' ' . $rab_rinci['satuan']; ?></td>
                                            <td class="text-right"><?= numberFormat($rab_rinci['hrg_satuan']); ?></td>
                                            <td class="text-right"><?= numberFormat($rab_rinci['anggaran']); ?></td>
                                            <td class="text-center"><?= $rab_rinci['jml_satuan_pak'] . ' ' . $rab_rinci['satuan']; ?></td>
                                            <td class="text-right"><?= numberFormat($rab_rinci['hrg_satuan_pak']); ?></td>
                                            <td class="text-right"><?= numberFormat($rab_rinci['anggaran_stlh_pak']); ?></td>
                                            <td><?= $rab_rinci['nama_jenis']; ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?= $this->include('backend/javasc'); ?>
<div class="modal fade" id="modal-jenis-belanja" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?= form_open($moduleUrl . '/update_jenis_belanja', ['class' => 'form-jenis-belanja']); ?>
            <div class="modal-header">
                <h5 class="modal-title label_head"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-body">
                    <h5 class="alert alert-info uraian-belanja"></h5>
                    <div class="row form-group">
                        <label class="col-md-3">Jenis Belanja</label>
                        <div class="col-md-9">
                            <select class="select2bs4 jenis-belanja" name="kd_jenis" style="width: 100%">
                                <option selected disabled value="">.: Pilih Jenis Belanja :.</option>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" class="form-control desa" name="kd_desa">
                    <input type="hidden" class="form-control kegiatan" name="kd_keg">
                    <input type="hidden" class="form-control rincian" name="kd_rincian">
                    <input type="hidden" class="form-control subrincian" name="kd_subrinci">
                    <input type="hidden" class="form-control no_urut" name="no_urut">
                    <?= getCsrf(); ?>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success btn-simpan"><i class="fa fa-save"></i> Simpan</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>
<script>
    $('.btn-edit').click(function () {
        const kd_jenis = $(this).data('kd_jenis');
        const uraian = $(this).data('uraian');
        const thisModal = $('#modal-jenis-belanja');
        thisModal.modal('show')
        thisModal.find('.modal-title').text('Input Data Jenis Belanja');
        thisModal.find('.modal-body input.desa').val($(this).data('kd_desa'));
        thisModal.find('.modal-body input.kegiatan').val($(this).data('kd_keg'));
        thisModal.find('.modal-body input.rincian').val($(this).data('kd_rincian'));
        thisModal.find('.modal-body input.subrincian').val($(this).data('kd_subrinci'));
        thisModal.find('.modal-body input.no_urut').val($(this).data('no_urut'));
        thisModal.find('.modal-body .uraian-belanja').text(uraian);
        $.getJSON(siteUrl('utility/jenis_belanja/load_jenis_belanja'), function (respon) {
            let htmls = '<option selected disabled value="">.: Pilih Jenis Belanja :.</option>';
            respon.forEach((res) => {
                const attrSelect = kd_jenis == res.kd_jenis ? 'selected' : '';
                htmls += `<option ${attrSelect} value="${res.kd_jenis}">${res.nama_jenis}</option>`
            })
            $('.jenis-belanja').html(htmls)
        })
    })

    $('.form-jenis-belanja').submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: 'json',
            beforeSend: () => {
                const btnSimpan = $('.btn-simpan');
                btnSimpan.html(`<i class="fa fa-spin fa-spinner"></i> Loading . . .`)
                btnSimpan.prop('disabled', true)
            },
            complete: () => {
                const btnSimpan = $('.btn-simpan');
                btnSimpan.html(`<i class="fa fa-save"></i>  &nbsp; Posting`)
                btnSimpan.prop('disabled', false)
            },
            success: (res) => {
                notifSmartAlert(res.status, res.ket)
            },
            error: (xhr, thrownError) => {
                notifSmartAlert(false, xhr.responseText)
            }
        })
    })
</script>
