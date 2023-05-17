<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card card-outline">
                <div class="card-header bg-gray-light">
                    Form Input Pegawai
                </div>
                <?= form_open(uri_string() . '/input-pegawai'); ?>
                <?= getCsrf(); ?>
                <div class="card-body">
                    <div class="row form-group">
                        <label class="col-md-3">NIP / NIK</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control nip_nik" placeholder="NIP / NIK" name="nip_nik"
                                   required>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <label>Nama Pegawai</label>
                            <input type="text" class="form-control nama_pegawai" placeholder="Nama Pegawai"
                                   name="nama_pegawai" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Nama Jabatan</label>
                        <input type="text" class="form-control jabatan" placeholder="Nama Jabatan" name="jabatan"
                               required>
                    </div>
                    <div class="form-group">
                        <label>No Telpon</label>
                        <input type="text" class="form-control no_telpon" placeholder="No Telpon" name="no_telpon"
                               required>
                    </div>
                    <input type="hidden" class="form-control id_pegawai" name="id_pegawai">
                </div>
                <div class="card-footer center">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-danger" onclick="window.location.reload()">Reset</button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card card-outline">
                <div class="card-header bg-gray">
                    Data Pegawai
                </div>
                <!-- /.box-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-hover tabel_3" width="100%">
                                    <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="15%">NIP / NIK</th>
                                        <th>Nama Pegawai</th>
                                        <th>Jabatan</th>
                                        <th>No Telpon</th>
                                        <th width="12%"><i class="fa fa-search"></i></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($getPegawai as $i => $row) {
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $i + 1; ?></td>
                                            <td><?= $row['nip_nik']; ?></td>
                                            <td><?= $row['nama_pegawai']; ?></td>
                                            <td><?= $row['jabatan']; ?></td>
                                            <td><?= $row['no_telpon']; ?></td>
                                            <td class="text-center">
                                                <?php
                                                $attrEdit = "data-id_pegawai='{$row['id_pegawai']}'
                                                             data-nama_pegawai='{$row['nama_pegawai']}'
                                                             data-no_telpon='{$row['no_telpon']}'
                                                             data-nip_nik='{$row['nip_nik']}'
                                                             data-jabatan='{$row['jabatan']}'";
                                                echo btn_edit($attrEdit, '', ' btn-xs btn-edit');
                                                $attrHps = "data-id_pegawai='{$row['id_pegawai']}'
                                                             data-nama_pegawai='{$row['nama_pegawai']}'";
                                                echo btn_hapus($attrHps, '', 'btn-xs btn-hapus');
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
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
    $('.btn-edit').click(function () {
        $('.nip_nik').val($(this).data('nip_nik'));
        $('.nama_pegawai').val($(this).data('nama_pegawai'));
        $('.id_pegawai').val($(this).data('id_pegawai'));
        $('.jabatan').val($(this).data('jabatan'));
        $('.no_telpon').val($(this).data('no_telpon'));
    });

    $('.btn-hapus').click(function () {
        const nama_pegawai = $(this).data('nama_pegawai');
        const id_pegawai = $(this).data('id_pegawai');
        swalWithBootstrapButtons({
            title: `Apa anda yakin menghapus Pegawai dangen Nama : ${nama_pegawai}`,
            text: "Silahkan Klik Tombol Delete Untuk Menghapus",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete ',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: siteUrl(`referensi/pegawai/delete`),
                    data: {id_pegawai, token: $('#token').val()},
                    dataType: 'json',
                    success: (res) => {
                        notifSmartAlert(res.status, res.message);
                    },
                    error: (request, status, error) => {
                        notifSmartAlert(false, request.responseText);
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons('Cancel', 'Tidak ada aksi hapus data', 'error')
            }
        })
    });
</script>