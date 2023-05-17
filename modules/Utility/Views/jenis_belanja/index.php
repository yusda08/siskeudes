<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="card card-outline">
                <form method="get">
                    <div class="card-header bg-gray-light">
                        <label>Pilih Level User</label>
                        <select class="select2bs4" id="kd_level" style="width: 100%" name="level"
                                onchange='this.form.submit();'>
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
        </div>
    </div>
    <?php
    if ($kd_level){
    ?>
    <div class="row">
        <div class="col-md-6">
            <div class="card card-outline">
                <div class="card-header bg-gray-light">
                    List Menu
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <?php foreach ($getMenu as $parent) {
                            if ($parent['parent'] == 0) {
                                if ($parent['link'] != '#') {
                                    ?>
                                    <li class="list-group-item list-group-item-secondary d-flex justify-content-between align-items-center bg-gray-active">
                                        <?= $parent['nama']; ?>
                                        <button data-id_menu="<?= $parent['id']; ?>"
                                                class="badge badge-primary badge-pill btn-parent">Send
                                        </button>
                                    </li>
                                    <?php
                                } else { ?>
                                    <li class="list-group-item list-group-item-secondary d-flex justify-content-between align-items-center">
                                        <?= $parent['nama']; ?>
                                    </li>
                                    <?php
                                    foreach ($getMenu as $child) {
                                        if ($child['parent'] == $parent['id']) {
                                            ?>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                &nbsp; &nbsp; &nbsp; &nbsp;<?= $child['nama']; ?>
                                                <button data-parent="<?= $child['parent']; ?>"
                                                        data-id_menu="<?= $child['id']; ?>"
                                                        class="badge badge-warning badge-pill btn-child">Send
                                                </button>
                                            </li>
                                            <?php
                                        }
                                    }
                                }
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-outline">
                <div class="card-header bg-gray-light">
                    Role Menu
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <?php foreach ($getMenuAkses as $akses_p) {
                            if ($akses_p['parent'] == 0) {
                                if ($akses_p['link'] != '#') {
                                    ?>
                                    <li class="list-group-item list-group-item-secondary d-flex align-items-center bg-gray-active">
                                        <div class="col-md-9">
                                            <?= $akses_p['nama']; ?>
                                        </div>
                                        <div class="col-md-3 text-right">
                                            <button data-id_menu="<?= $akses_p['id']; ?>"
                                                    class="badge badge-primary badge-pill btn-akses">Aktif
                                            </button>
                                            <button data-id_menu="<?= $akses_p['id']; ?>"
                                                    class="badge badge-danger badge-pill btn-akses"><i
                                                        class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </li>
                                    <?php
                                } else { ?>
                                    <li class="list-group-item list-group-item-secondary d-flex justify-content-between align-items-center">
                                        <?= $akses_p['nama']; ?>
                                        <button data-id_menu="<?= $akses_p['id']; ?>"
                                                class="badge badge-danger badge-pill btn-akses"><i
                                                    class="fa fa-trash"></i>
                                        </button>
                                    </li>
                                    <?php
                                    foreach ($getMenuAkses as $akses_c) {
                                        if ($akses_c['parent'] == $akses_p['id']) {
                                            ?>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                &nbsp; &nbsp; &nbsp; &nbsp;<?= $akses_c['nama']; ?>

                                                <button data-id_menu="<?= $akses_c['id']; ?>"
                                                        class="badge badge-danger badge-pill btn-akses"><i
                                                            class="fa fa-trash"></i>
                                                </button>
                                            </li>
                                            <?php
                                        }
                                    }
                                }
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<?= getCsrf(); ?>
<?= $this->include('backend/javasc'); ?>
<script>
    const token = $('#token').val();
    const kd_level = $('#kd_level').val();
    $('.btn-parent').click(function () {
        const id_menu = $(this).data('id_menu');
        $.ajax({
            type: 'POST',
            url: '<?= site_url($moduleUrl . '/input_menu'); ?>',
            dataType: 'json',
            data: {id_menu, token, kd_level},
            success: (res) => {
                // console.log()
                notifSmartAlert(res.status, res.ket);
            },
        });
    })
    $('.btn-child').click(function () {
        const id_menu = $(this).data('id_menu');
        const parent = $(this).data('parent');
        $.ajax({
            type: 'POST',
            url: '<?= site_url($moduleUrl . '/input_menu'); ?>',
            dataType: 'json',
            data: {id_menu, parent, token, kd_level},
            success: (res) => {
                // console.log()
                notifSmartAlert(res.status, res.ket);
            },
        });
    })
    $('.btn-akses').click(function () {
        const id_menu = $(this).data('id_menu')
        swalWithBootstrapButtons({
            title: 'Apa anda yakin Menghapus Menu pada Level User ini',
            text: "Silahkan Klik Tombol Delete Untuk melakukan Aksi",
            type: 'info',
            showCancelButton: true,
            confirmButtonText: 'Delete ',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?= site_url($moduleUrl . '/delete_menu'); ?>",
                    dataType: 'json',
                    data: {id_menu, token, kd_level},
                    success: (res) => {
                        notifSmartAlert(res.status, res.ket)
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

</script>