<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card card-outline">
                <div class="card-header bg-gray-light">
                    Form Pencarian Kegiatan
                </div>
                <form method="GET">
                    <div class="card-body">
                        <div class="row form-group">
                            <div class="col-md-12">
                                <label>Desa</label>
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
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <label>Bidang</label>
                                <select class="select2bs4 bidang" name="bidang" style="width: 100%">
                                    <option selected disabled value="">.: Pilih Bidang :.</option>
                                    <?php
                                    foreach ($getTaBidang as $bid) {
                                        if ($kd_desa == $bid['kd_desa']) {
                                            $attrBid = $kd_bidang == $bid['kd_bid'] ? 'selected' : '';
                                            echo "<option $attrBid value='{$bid['kd_bid']}'>{$bid['nama_bidang']}</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <label>Sub Bidang</label>
                                <select class="select2bs4 subbidang" name="subbidang" style="width: 100%">
                                    <option selected disabled value="">.: Pilih Sub Bidang :.</option>
                                    <?php
                                    foreach ($getTaSubBidang as $subbid) {
                                        if ($kd_bidang == $subbid['kd_bid']) {
                                            $attrSubBid = $kd_subbid == $subbid['kd_sub'] ? 'selected' : '';
                                            echo "<option $attrSubBid value='{$subbid['kd_sub']}'>{$subbid['nama_subbidang']}</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer center">
                        <button class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card card-outline">
                <div class="card-header bg-gray">
                    Data Kegiatan
                </div>
                <!-- /.box-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-hover tabel_3" width="100%">
                                    <thead>
                                    <tr>
                                        <th width="15%">Kode</th>
                                        <th>Nama Kegiatan</th>
                                        <th width="12%"><i class="fa fa-search"></i></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($getTaKegiatan as $row_keg) {
                                        if($kd_subbid == $row_keg['kd_sub']){
                                        ?>
                                        <tr>
                                            <td><?=$row_keg['kd_keg'];?></td>
                                            <td><?=$row_keg['nama_kegiatan'];?></td>
                                            <td>
                                                <?= form_open(site_url($moduleUrl.'/rab'),['method'=>'GET']);?>
                                                <input type="hidden" class="form-control" name="desa" value="<?=$kd_desa;?>">
                                                <input type="hidden" class="form-control" name="kegiatan" value="<?=$row_keg['kd_keg'];?>">
                                                <button class="btn btn-primary btn-xs btn-block btn-flat">
                                                    <i class="fa fa-search"></i> RAB
                                                </button>
                                                <?= form_close();?>
                                            </td>
                                        </tr>
                                        <?php
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

    </div>
</div>
<?= $this->include('backend/javasc'); ?>
<script>
    $('.desa').change(function () {
        // $(this).find('option:selected').data('nip_nik')
        const desa = $(this).val();
        $.getJSON(siteUrl('<?=$moduleUrl;?>/load_ta_bidang'), {desa}, function (respon) {
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
        $.getJSON(siteUrl('<?=$moduleUrl;?>/load_ta_subbidang'), {bidang}, function (respon) {
            console.log(respon);
            let htmls = `<option selected disabled value="">.: Pilih Sub Bidang :.</option>`;
            respon.forEach((res) => {
                htmls += `<option value="${res.kd_sub}">${res.nama_subbidang}</option>`;
            })
            $('.subbidang').html(htmls);
        })
    });
</script>