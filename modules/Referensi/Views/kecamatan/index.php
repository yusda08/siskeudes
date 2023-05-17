<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-outline">
                <div class="card-header bg-gray">
                    Data Kecamatan
                </div>
                <!-- /.box-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-hover tabel_3" width="100%">
                                    <thead>
                                    <tr>
                                        <th width="5%">Kode</th>
                                        <th>Kecamatan / Desa</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="bg-gray-light">
                                        <td><?= $row_kec['kd_kec']; ?></td>
                                        <td><?= $row_kec['nama_kecamatan']; ?></td>
                                    </tr>
                                    <?php foreach ($getDesa as $row_desa) {
                                        if ($row_kec['kd_kec'] == $row_desa['kd_kec']) {
                                            ?>
                                            <tr>
                                                <td><?= $row_desa['kd_desa']; ?></td>
                                                <td><?= textCapital($row_desa['nama_desa']); ?></td>
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
