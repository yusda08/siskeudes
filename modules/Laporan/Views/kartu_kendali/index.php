<?php
//$url = getUrl();
echo $javasc;
echo $notifikasi;
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline">
                <div class="card-header bg-gray">
                    Nota Dinas / Telaahan Staf
                </div>
                <!-- /.box-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-hover tabel-server-side" width="100%">
                                    <thead>
                                    <tr>
                                        <th width="8%">Agenda</th>
                                        <th>No Surat</th>
                                        <th>Asal Surat</th>
                                        <th>Perihal Surat</th>
                                        <th>Tanggal Surat</th>
                                        <th>Tanggal Diterima</th>
                                        <th><i class="fa fa-print"></i></th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        load_data()

        function load_data(status = '') {
            $('.tabel-server-side').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                paging: true,
                info: true,
                autoWidth: true,
                pageLength: 25,
                lengthChange: true,
                scrollCollapse: false,
                deferRender: true,
                ajax: {
                    url: "<?= site_url('surat_masuk/data_surat/load_nota_dinas'); ?>",
                    type: "POST",
                    data: {status: status},
                },
                columns: [// Tampilkan nis
                    {data: "no_reg"},
                    {
                        "render": function (data, type, row) { // Tampilkan kolom aksi
                            return viewSuratHtml(row);
                        }
                    },
                    // {data: "no_surat"},
                    {data: "pembuat"},
                    {data: "perihal"},
                    {data: "tgl_surat"},
                    {data: "tgl_masuk"},
                    {
                        "render": function (data, type, row) { // Tampilkan kolom aksi
                            return statusHtml(row);
                        }
                    }
                ],
                columnDefs: [
                    {className: "text-center", targets: [0, 4, 5]}
                ]
            });
            const viewSuratHtml = (row) => {
                return `<a target="_blank" href="${siteUrl(`surat_masuk/nota_dinas/view_nota_dinas?no_reg=${row.no_reg}`)}"
                class="btn btn-link btn-xs">${row.no_surat}</a>`;
            }
            const statusHtml = (row) => {
                return `<a target="_blank" href="${siteUrl(`laporan/kartu_kendali/cetak_kartu_kendali?no_reg=${row.no_reg}`)}"
                            class="btn btn-danger btn-block btn-flat btn-xs">
                            <i class="fa fa-print"></i> Kartu Kendali
                        </a>`;
            }
        }
    });
</script>