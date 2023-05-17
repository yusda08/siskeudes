<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card card-outline">
                <form method="get">
                    <div class="card-header bg-gray-light">
                        <label>Pilih Level User</label>
                        <select class="select2bs4" style="width: 100%" name="level" onchange='this.form.submit();'>
                            <option disabled selected value="">.: Level User :.</option>
                            <?php
                            foreach ($getUserLevel as $lvl) {
                                $attrSel = $lvl['kd_level'] == $kd_level ? 'selected' : '';
                                echo "<option $attrSel value='{$lvl['kd_level']}'>{$lvl['ket_level']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </form>
            </div>
            <?php
            if ($kd_level) { ?>
                <div class="card card-outline">
                    <div class="card-header bg-gray-light">
                        Form Input User
                    </div>
                    <?= form_open(uri_string() . '/add-user'); ?>
                    <?= getCsrf(); ?>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text"
                                   class="form-control username"
                                   placeholder="Username" name="username" required>
                        </div>
                        <div class="form-group text-password">
                            <label>Password</label>
                            <input type="password"
                                   class="form-control password"
                                   name="password" required placeholder="Password">
                        </div>
                        <?php
                        if ($kd_level == 2) { ?>
                            <div class="form-group">
                                <label>Desa</label>
                                <select class="select2bs4 data-desa" name="kd_desa" style="width: 100%">
                                    <option value="" disabled selected>.: Pilih Desa :.</option>
                                    <?php
                                    foreach ($getDesa as $desa) {
                                        $attrLevel = '';
                                        foreach ($getUser as $cek) {
                                            if ($cek['kd_desa'] == $desa['kd_desa']) {
                                                $attrLevel = 'disabled';
                                                break;
                                            }
                                        }
                                        echo "<option {$attrLevel} data-nama_desa='{$desa['nama_desa']}' value='{$desa['kd_desa']}'>{$desa['nama_desa']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <?php
                        }
                        if ($kd_level == 3) { ?>
                            <div class="form-group">
                                <label>Pegawai</label>
                                <select class="select2bs4 data-pegawai" name="nip_nik" style="width: 100%">
                                    <option value="" disabled selected>.: Pilih Pegawai :.</option>
                                    <?php
                                    foreach ($getPegawai as $pegawai) {
                                        $attrLevel = '';
                                        foreach ($getUser as $cek) {
                                            if ($cek['nip_nik'] == $pegawai['nip_nik']) {
                                                $attrLevel = 'disabled';
                                                break;
                                            }
                                        }
                                        echo "<option {$attrLevel} data-nama_pegawai='{$pegawai['nama_pegawai']}' value='{$pegawai['nip_nik']}'>{$pegawai['nama_pegawai']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="form-group">
                            <label>Nama User</label>
                            <input type="text" <?= $kd_level == 2 || $kd_level == 3 ? 'readonly' : ''; ?>
                                   class="form-control nama_user" placeholder="Nama User" name="nama_user" required>
                        </div>
                        <input type="hidden" class="form-control" name="kd_level" value="<?= $kd_level; ?>">

                    </div>
                    <div class="card-footer center">
                        <button type="submit" class="btn btn-primary btn-save">Simpan</button>
                        <button type="button" class="btn btn-danger" onclick="window.location.reload()">Reset
                        </button>
                    </div>
                    <?= form_close(); ?>
                </div>
                <?php
            } ?>
        </div>
        <div class="col-md-8">
            <?php if ($kd_level) { ?>
            <div class="card card-outline">
                <div class="card-header bg-gray">
                    <h3 class="card-title">Data User</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                    class="fas fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="card-body">
                    <table class="table table-sm table-hover table-bordered tabel_2" width='100%'>
                        <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Username</th>
                            <th>Nama User</th>
                            <th width="8%">Status</th>
                            <th width="15%">Reset</th>
                            <th width="8%"><i class="fa fa-refresh"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $no = 1;
                        foreach ($getUser as $row) {
                            $att = $row['kd_user'] == 1 ? 'disabled' : '';
                            ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td><?= $row['username']; ?></td>
                                <td><?= $row['nama_user']; ?></td>
                                <td class="text-center">
                                    <input <?= $row['is_active'] == 1 ? "checked='checked'" : ''; ?>
                                        <?= $att; ?> class="form-check btn-isactive" type="checkbox"
                                                     data-kd_user="<?= $row['kd_user']; ?>"
                                                     data-is_active="<?= $row['is_active'] ?>"
                                                     name="checkbox-toggle">
                                </td>
                                <td class="text-center">
                                    <?= btnAction(attrBtn: $att . " data-kd_user='{$row['kd_user']}'", labelBtn: 'Reset Pass', classBtn: 'btn-xs btn-flat btn-reset'); ?>
                                </td>
                                <td class="text-center">
                                    <?= btnAction('delete', attrBtn: $att . " data-kd_user='{$row['kd_user']}'", classBtn: 'btn-xs btn-flat btn-delete'); ?>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php
    } else {
        statusWarning(' Pilih Level User', 'Pilih Terlebih Dahulu Level User untuk melakukan Aksi !!!');
    } ?>
</div>
<?= $this->include('backend/javasc'); ?>
<script>
    $('.data-desa').change(function () {
        const nama_desa = $(this).find('option:selected').data('nama_desa')
        $('.nama_user').val(nama_desa);
    });

    $('.data-pegawai').change(function () {
        const nama_pegawai = $(this).find('option:selected').data('nama_pegawai')
        $('.nama_user').val(nama_pegawai);
    })


    $('.btn-isactive').click(function () {
        const kd_user = $(this).data('kd_user');
        const is_active = $(this).data('is_active');
        $.ajax({
            type: 'POST',
            url: siteUrl('setting/user'),
            dataType: 'json',
            data: {
                kd_user: kd_user,
                is_active: is_active
            },
            success: (res) => {
                notifSmartAlert(res.status, res.ket);
            },
        });
    })
    $('.btn-reset').click(function () {
        const kd_user = $(this).data('kd_user')
        swalWithBootstrapButtons({
            title: 'Apa anda yakin Reset Password User dengan Password Default : 123456',
            text: "Silahkan Klik Tombol Reser Untuk melakukan Aksi",
            type: 'info',
            showCancelButton: true,
            confirmButtonText: 'Reset ',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: siteUrl('setting/user/reset_password'),
                    dataType: 'json',
                    data: {kd_user},
                    success: (res) => {
                        notifSmartAlert(res.status, res.message)
                    },
                    error: (request, status, error) => {
                        notifSmartAlert(false, request.responseText);
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons(
                    'Cancel',
                    'Tidak ada aksi hapus data',
                    'error'
                )
            }
        })
    })

    $(document).ready(function () {
        callBackClassAfter('.username', 'cek-username');
        $('.username').change(function () {
            const username = $(this).val();
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: siteUrl(),
                data: {username: username},
                success: (result) => {
                    if (result == null) {
                        $('.btn-save').prop('disabled', false);
                        $('.cek-username').html('<img src="<?= base_url('assets/img/true.png'); ?>"><b style="color:green;"> Username Valid</b>');
                    } else {
                        $('.btn-save').prop('disabled', true);
                        $('.cek-username').html('<img src="<?= base_url('assets/img/false.png'); ?>"><b style="color:red;"> Username Double</b>');
                    }
                }
            });
        });
    });

    $('.btn-delete').click(function () {
        const kd_user = $(this).data('kd_user')
        swalWithBootstrapButtons({
            title: 'Apa anda yakin menghapus User ini ? ',
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
                    url: siteUrl('setting/user/delete_user'),
                    dataType: 'json',
                    data: {kd_user, token: $('#token').val()},
                    success: (res) => {
                        notifSmartAlert(res.status, res.message)
                    },
                    error: function (request, status, error) {
                        notifSmartAlert(false, request.responseText);
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons(
                    'Cancel',
                    'Tidak ada aksi hapus data',
                    'error'
                )
            }
        })
    })
</script>