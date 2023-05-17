<?php
//$url = getUrl();
echo $javasc;
echo $notifikasi;
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline">
                <div class="card-body bg-gray-light">
                    <form name="form_nip" method="GET">
                        <div class="row justify-content-between">
                            <div class="col-md-4">
                                <select class="select2bs4" name="bidang" style="width: 100%" onchange='document.form_nip.submit();'>
                                    <option value="">.: Pilih Bidang</option>
                                    <?php foreach ($getRefBidang as $bid) { ?> 
                                        <option 
                                        <?= $kd_bidang == $bid->kd_bidang ? 'selected' : ''; ?> 
                                            value="<?= $bid->kd_bidang; ?>"><?= $bid->nama_bidang; ?></option>
                                        <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-6">
                                <select class="select2bs4" style="width: 100%" name="tahun" onchange='document.form_nip.submit();'>
                                    <option value="">.: Pilih Tahun :.</option>
                                    <?php for ($i = 2020; $i <= date('Y'); $i++) { ?>
                                        <option 
                                        <?php
                                        if ($i == $tahun) {
                                            echo 'selected';
                                        }
                                        ?>
                                            value="<?= $i; ?>">Tahun <?= $i; ?></option>
                                        <?php } ?>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card card-outline">
                <div class="card-header bg-gray">
                    Data Surat Keluar
                </div>
                <!-- /.box-header -->
                <div class="card-body">
                    <?php if (!empty($tahun) and ! empty($kd_bidang)) { ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover tabel-server-side" width="100%">
                                        <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <th>No Surat</th>
                                                <th>Perihal Surat</th>
                                                <th>Tanggal Surat</th>
                                                <th>Tujuan</th>
                                                <th>Jenis Surat</th>
                                                <th width="12%"><i class="fa fa-print"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                        <?php
                    } else {
                        $status = ' Pilih Bidang SKPD';
                        $ket = 'silahkan pilih Bidang untuk menampilkan data Surat_masuk Keluar !!!';
                        statusWarning($status, $ket);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.tabel-server-side').DataTable({
            processing: true,
            serverSide: true,
            ordering: false,
            pageLength: 25,
            scroller: {
                loadingIndicator: true,
                displayBuffer: 20
            },
            ajax: {
                url: "<?= base_url('laporan/surat_keluar/load_surat_keluar'); ?>",
                type: "POST",
                data: {tahun: '<?= $tahun; ?>', kd_bidang: '<?= $kd_bidang; ?>'}

            },
            columnDefs: [
                {
                    targets: [0, 4, 5, 6],
                    className: 'text-center'
                }
            ]
        });
    });
</script>